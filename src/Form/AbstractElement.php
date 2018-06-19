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
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * @var string
     */
    protected $defaultTemplate = '';

    /**
     * @var array
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
     * @var array
     */
    protected $allowedAttributeValues = [
        'contenteditable' => ['true', 'false'],
        'dir' => ['ltr', 'rtl'],
        'draggable' => ['true', 'false'],
        'spellcheck' => ['true', 'false'],
    ];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var StringTemplate
     */
    protected $templater;

    /**
     * Helper constructor.
     * Init template engine
     *
     */
    public function __construct()
    {
        $this->templater = new StringTemplate();
    }

    /**
     * @return HtmlString
     */
    abstract public function render(): HtmlString;

    /**
     * @return array
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
        /** @var string $template */
        if ($template = config('laravel-form.templates.' . static::class)) {
            return $template;
        }

        return $this->defaultTemplate;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function validateAttributes(array $options = []): array
    {
        foreach ($options as $key => $value) {
            if (!in_array($key, $this->allowedAttributes)) {
                unset($options[$key]);
            } else {
                if (false === $this->validateAttributeValue($key, $options[$key])) {
                    unset($options[$key]);
                }
            }
        }

        return $options;
    }

    /**
     * @param string $key
     * @param string|null $value
     * @return bool
     */
    private function validateAttributeValue(string $key, string $value = null): bool
    {
        if (empty($this->allowedAttributeValues[$key])) {
            return true;
        }

        return !empty($value) && in_array($value, $this->allowedAttributeValues[$key]);
    }
}
