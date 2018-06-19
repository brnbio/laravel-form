<?php

/**
 * Context.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use Cake\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Context
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm\Form
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
        if (! empty($this->metadata[$fieldName])) {
            return $this->metadata[$fieldName];
        }

        return [];
    }

    /**
     * @param string $tableName
     * @return array
     */
    private function initMetadata(string $tableName): array
    {
        $metadata = [];
        $fields = DB::connection()->select('SHOW FIELDS FROM ' . $tableName);
        foreach ($fields as $field) {
            preg_match('/([a-z]+)\(*(\d*)\)*\s?([a-z\s]*)/', $field->Type, $fieldType);
            $metadata[$field->Field] = [
                'name' => $field->Field,
                'type' => $fieldType[1],
                'required' => $field->Null === 'NO' && $field->Default === null,
                'default' => $field->Default,
                'maxlength' => ! empty($fieldType[2]) ? $fieldType[2] : null,
            ];
        }

        return $metadata;
    }
}
