<?php

/**
 * Context.php
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use DateInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Class Context
 *
 * @package Brnbio\LaravelForm\Form
 */
class Context
{
    public const CACHE_METADATA_STORAGE = 'file';
    public const CACHE_METADATA_PREFIX = '_db_metadata_';
    public const CACHE_METADATA_TTL = 'P1Y';

    /**
     * @var Model
     */
    protected $entity;

    /**
     * @var mixed[]
     */
    protected $metadata = [];

    /**
     * Context constructor.
     *
     * @param Model $entity
     * @throws InvalidArgumentException
     */
    public function __construct(Model $entity)
    {
        $this->entity = $entity;
        $this->metadata = $this->initMetadata($entity->getTable());
    }

    /**
     * @param string $fieldName
     * @return array
     */
    public function getMetadata(string $fieldName): array
    {
        if ( !empty($this->metadata[$fieldName])) {
            return $this->metadata[$fieldName];
        }

        return [];
    }

    /**
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->entity;
    }

    /**
     * @param string $tableName
     * @return array
     * @throws InvalidArgumentException
     */
    private function initMetadata(string $tableName): array
    {
        $metadata = $this->getMetadataFromCache($tableName);
        if ( !empty($metadata)) {
            return $metadata;
        }

        $connection = $this->getEntity()->getConnection();

        if ($connection->getDriverName() === 'mysql') {
            $metadata = $this->getMysqlMetadata($connection, $tableName);

            return $this->storeMetadataToCache($tableName, $metadata);
        }

        if ($connection->getDriverName() === 'sqlite') {
            $metadata = $this->getSqliteMetadata($connection, $tableName);

            return $this->storeMetadataToCache($tableName, $metadata);
        }

        return [];
    }

    /**
     * @param Connection $connection
     * @param string $tableName
     * @return array
     */
    private function getMysqlMetadata(Connection $connection, string $tableName): array
    {
        $metadata = [];
        $fields = $connection->select('SHOW FIELDS FROM ' . $tableName);
        foreach ($fields as $field) {
            preg_match('/([a-z]+)\(*(\d*)\)*\s?([a-z\s]*)/', $field->Type, $fieldType);
            $metadata[$field->Field] = [
                'name'      => $field->Field,
                'type'      => $fieldType[1],
                'required'  => $field->Null === 'NO' && $field->Default === null,
                'default'   => $field->Default,
                'maxlength' => !empty($fieldType[2]) ? (int) $fieldType[2] : null,
            ];
        }

        return $metadata;
    }

    /**
     * @param Connection $connection
     * @param string $tableName
     * @return array
     */
    private function getSqliteMetadata(Connection $connection, string $tableName): array
    {
        $metadata = [];
        $fields = $connection->select('PRAGMA table_info(' . $tableName . ')');
        foreach ($fields as $field) {
            $metadata[$field->name] = [
                'name'      => $field->name,
                'type'      => $field->type,
                'required'  => (boolean) $field->notnull,
                'default'   => $field->dflt_value,
                'maxlength' => null,
            ];
        }

        return $metadata;
    }

    /**
     * @param string $tableName
     * @param array $metadata
     * @return array
     */
    private function storeMetadataToCache(string $tableName, array $metadata): array
    {
        $key = $this->getCacheKey($tableName);
        Cache::store(self::CACHE_METADATA_STORAGE)
            ->put($key, $metadata, new DateInterval(self::CACHE_METADATA_TTL));

        return $metadata;
    }

    /**
     * @param string $tableName
     * @return array
     * @throws InvalidArgumentException
     */
    private function getMetadataFromCache(string $tableName): array
    {
        $key = $this->getCacheKey($tableName);

        return Cache::store(self::CACHE_METADATA_STORAGE)->get($key, []);
    }

    /**
     * @param string $tableName
     * @return string
     */
    private function getCacheKey(string $tableName): string
    {
        return self::CACHE_METADATA_PREFIX . $tableName;
    }
}
