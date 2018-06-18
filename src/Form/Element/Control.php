<?php

/**
 * Control.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;

/**
 * Class Control
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class Control extends AbstractElement
{
    /**
     * @var array
     */
    protected $defaultOptions = [
        'class' => null,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<div{{attrs}}>{{label}}{{control}}</div>';

    /**
     * @var array
     */
    protected $allowedAttributes = [
        'class',
    ];

    /**
     * Control constructor
     *
     * @param string $fieldName
     * @param array $options
     * @param array $metadata
     */
    public function __construct(string $fieldName, array $options = [], array $metadata = [])
    {
        $options += $this->defaultOptions;

        if (null === $options['class']) {
            $options['class'] = config('laravel-form.css.inputContainer');
            if (!empty($metadata['type'])) {
                $options['class'] .= ' ' . $metadata['type'];
            }
            if (!empty($metadata['required'])) {
                $options['class'] .= ' ' . config('laravel-form.css.required');
            }
        }

        $this->attributes = $this->validateAttributes($options);
    }
}
