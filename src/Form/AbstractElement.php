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
     * Attribute names
     */
    public const ATTRIBUTE_ACCEPT_CHARSET = 'accept-charset';
    public const ATTRIBUTE_ACCESS_KEY = 'accesskey';
    public const ATTRIBUTE_ACTION = 'action';
    public const ATTRIBUTE_AUTOCOMPLETE = 'autocomplete';
    public const ATTRIBUTE_AUTOFOCUS = 'autofocus';
    public const ATTRIBUTE_CLASS = 'class';
    public const ATTRIBUTE_CONTENT_EDITABLE = 'contenteditable';
    public const ATTRIBUTE_CONTEXT_MENU = 'contextmenu';
    public const ATTRIBUTE_DIR = 'dir';
    public const ATTRIBUTE_DISABLED = 'disabled';
    public const ATTRIBUTE_DRAGGABLE = 'draggable';
    public const ATTRIBUTE_ENCTYPE = 'enctype';
    public const ATTRIBUTE_FOR = 'for';
    public const ATTRIBUTE_FORM = 'form';
    public const ATTRIBUTE_HIDDEN = 'hidden';
    public const ATTRIBUTE_ID = 'id';
    public const ATTRIBUTE_LANG = 'lang';
    public const ATTRIBUTE_METHOD = 'method';
    public const ATTRIBUTE_NAME = 'name';
    public const ATTRIBUTE_NO_VALIDATE = 'novalidate';
    public const ATTRIBUTE_SPELLCHECK = 'spellcheck';
    public const ATTRIBUTE_STYLE = 'style';
    public const ATTRIBUTE_TABINDEX = 'tabindex';
    public const ATTRIBUTE_TARGET = 'target';
    public const ATTRIBUTE_TYPE = 'type';
    public const ATTRIBUTE_TITLE = 'title';
    public const ATTRIBUTE_VALUE = 'value';

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
        self::ATTRIBUTE_ACCESS_KEY,
        self::ATTRIBUTE_CLASS,
        self::ATTRIBUTE_CONTENT_EDITABLE,
        self::ATTRIBUTE_CONTEXT_MENU,
        self::ATTRIBUTE_DIR,
        self::ATTRIBUTE_DRAGGABLE,
        self::ATTRIBUTE_HIDDEN,
        self::ATTRIBUTE_ID,
        self::ATTRIBUTE_LANG,
        self::ATTRIBUTE_SPELLCHECK,
        self::ATTRIBUTE_STYLE,
        self::ATTRIBUTE_TABINDEX,
        self::ATTRIBUTE_TITLE,
    ];

    /**
     * @var mixed[]
     */
    protected $allowedAttributeValues = [
        self::ATTRIBUTE_CONTENT_EDITABLE => [
            'true',
            'false',
        ],
        self::ATTRIBUTE_DIR => [
            'ltr',
            'rtl',
        ],
        self::ATTRIBUTE_DRAGGABLE => [
            'true',
            'false',
        ],
        self::ATTRIBUTE_SPELLCHECK => [
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

    /**
     * @return HtmlString
     */
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
        return (string)config('laravel-form.templates.' . static::class) ?: $this->defaultTemplate;
    }

    /**
     * @param mixed[] $options
     * @return mixed[]
     */
    protected function validateAttributes(array $options = [], array $exclude = []): array
    {
        foreach ($options as $key => $value) {
            // -- single word options like disabled or required
            if (is_numeric($key)) {
                unset($options[$key]);
                $key = $value;
                $options[$key] = $value;
            }
            if (! in_array($key, $this->allowedAttributes, true) || in_array($key, $exclude)) {
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
