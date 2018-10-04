<?php

/**
 * Textarea.php
 *
 * The textarea element represents a multiline plain text edit control.
 * The contents of the control represent the control's default value.
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-10-04
 * @link        https://www.w3.org/TR/html/sec-forms.html#the-textarea-element
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;

/**
 * Class Textarea
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class Textarea extends AbstractElement
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string|null
     */
    protected $value = null;

    /**
     * Input constructor.
     *
     * @param string $fieldName
     * @param array $options
     */
    public function __construct(string $fieldName, array $options = [])
    {
        parent::__construct();

        if (! isset($options[self::ATTRIBUTE_CLASS])) {
            $options[self::ATTRIBUTE_CLASS] = config('laravel-form.css.input');
        }

        if (isset($options[self::ATTRIBUTE_VALUE])) {
            $this->value = $options[self::ATTRIBUTE_VALUE];
            unset($options[self::ATTRIBUTE_VALUE]);
        }

        $this->fieldName = $fieldName;
        $this->attributes = $this->validateAttributes($options + $this->defaultOptions);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'name' => $this->fieldName,
                'value' => $this->value,
                'attrs' => $this->templater->formatAttributes($this->attributes, [
                    self::ATTRIBUTE_NAME,
                    self::ATTRIBUTE_VALUE,
                ]),
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_AUTOCOMPLETE,
            self::ATTRIBUTE_AUTOFOCUS,
            self::ATTRIBUTE_COLS,
            self::ATTRIBUTE_DIRNAME,
            self::ATTRIBUTE_DISABLED,
            self::ATTRIBUTE_FORM,
            self::ATTRIBUTE_MAXLENGTH,
            self::ATTRIBUTE_MINLENGTH,
            self::ATTRIBUTE_NAME,
            self::ATTRIBUTE_PLACEHOLDER,
            self::ATTRIBUTE_READONLY,
            self::ATTRIBUTE_REQUIRED,
            self::ATTRIBUTE_ROWS,
            self::ATTRIBUTE_WRAP,
        ]);
    }
}
