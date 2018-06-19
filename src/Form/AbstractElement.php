<?php

/**
 * AbstractElement.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use Brnbio\LaravelForm\Template\StringTemplate;
use Illuminate\Support\HtmlString;

/**
 * Class AbstractElement
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form
 */
abstract class AbstractElement
{
    /**
     * @var mixed[]
     */
    protected $defaultOptions = [];

    /**
     * @var string
     */
    protected $defaultTemplate = '';

    /**
     * @var string[]
     */
    protected $allowedAttributes = [
        'accesskey',
        'class',
        'contenteditable',
        'contextmenu',
        'dir',
        'draggable',
        'hidden',
        'id',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
    ];

    /**
     * @var mixed[]
     */
    protected $allowedAttributeValues = [
        'contenteditable' => [
            'true',
            'false',
        ],
        'dir' => [
            'ltr',
            'rtl',
        ],
        'draggable' => [
            'true',
            'false',
        ],
        'spellcheck' => [
            'true',
            'false',
        ],
    ];

    /**
     * @var mixed[]
     */
    protected $attributes = [];

    /**
     * @var StringTemplate
     */
    protected $templater;

    /**
     * Helper constructor.
     * Init template engine
     */
    public function __construct()
    {
        $this->templater = new StringTemplate();
        $this->addAdditionalAllowedAttributes();
        $this->addAdditionalAllowedAttributesValues();
    }

    abstract public function render(): HtmlString;

    /**
     * @return mixed[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return config('laravel-form.templates.' . static::class) ?: $this->defaultTemplate;
    }

    /**
     * @param mixed[] $options
     * @return mixed[]
     */
    protected function validateAttributes(array $options = []): array
    {
        foreach ($options as $key => $value) {
            if (is_numeric($key)) {
                unset($options[$key]);
                $key = $value;
                $options[$key] = $value;
            }
            if (! in_array($key, $this->allowedAttributes, true)) {
                unset($options[$key]);
            } else {
                if ($this->validateAttributeValue($key, $options[$key]) === false) {
                    unset($options[$key]);
                }
            }
        }

        return $options;
    }

    /**
     * @param string[] $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        $this->allowedAttributes = array_merge($this->allowedAttributes, $attributes);
    }

    /**
     * @param mixed[] $attributesValues
     */
    protected function addAdditionalAllowedAttributesValues(array $attributesValues = []): void
    {
        $this->allowedAttributeValues = array_merge($this->allowedAttributeValues, $attributesValues);
    }

    /**
     * @param string $key
     * @param mixed|null $value
     * @return bool
     */
    private function validateAttributeValue(string $key, $value = null): bool
    {
        if (empty($this->allowedAttributeValues[$key])) {
            return true;
        }

        return ! empty($value) && in_array($value, $this->allowedAttributeValues[$key], true);
    }
}
