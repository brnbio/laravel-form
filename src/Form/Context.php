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

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Context
 *
 * @package Brnbio\LaravelForm\Form
 */
class Context
{
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
     */
    private function initMetadata(string $tableName): array
    {
        $connection = $this->getEntity()->getConnection();

        if ($connection->getDriverName() === 'mysql') {
            return $this->getMysqlMetadata($connection, $tableName);
        }

        if ($connection->getDriverName() === 'sqlite') {
            return $this->getSqliteMetadata($connection, $tableName);
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
}
