<?php

/**
 * Checkbox.php
 *
 * The input element with a type attribute whose value is "checkbox" represents a state or option that can be toggled.
 * The checkbox form helper element contain a wrapper.
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-22
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/input.checkbox.html
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Brnbio\LaravelForm\Form\Helper;
use Illuminate\Support\HtmlString;

/**
 * Class Checkbox
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm\Form\Element
 */
class Checkbox extends AbstractElement
{
    public const CHECKBOX_ATTRIBUTE_CONTAINER = '_container';
    public const CHECKBOX_ATTRIBUTE_LABEL = '_label';

    /**
     * @var array
     */
    protected $defaultOptions = [
        self::ATTRIBUTE_VALUE => 1,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<div{{attrs}}>{{label}}</div>';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    protected $label;

    /**
     * Insert a hidden input field to definitly set a value to this field
     *
     * @var bool
     */
    protected $hiddenField = true;

    /**
     * Checkbox constructor.
     * @param string $fieldName
     * @param array $options
     */
    public function __construct(string $fieldName, string $label, array $options = [])
    {
        parent::__construct();

        if (isset($options['hiddenField'])) {
            $this->hiddenField = (bool)$options['hiddenField'];
        }

        if (! isset($options[self::ATTRIBUTE_CLASS])) {
            $options[self::ATTRIBUTE_CLASS] = config('laravel-form.css.checkbox');
        }
        if (! isset($options[self::CHECKBOX_ATTRIBUTE_CONTAINER][self::ATTRIBUTE_CLASS])) {
            $options[self::CHECKBOX_ATTRIBUTE_CONTAINER][self::ATTRIBUTE_CLASS] = config('laravel-form.css.checkboxContainer');
        }
        if (! isset($options[self::CHECKBOX_ATTRIBUTE_LABEL][self::ATTRIBUTE_CLASS])) {
            $options[self::CHECKBOX_ATTRIBUTE_LABEL][self::ATTRIBUTE_CLASS] = config('laravel-form.css.checkboxLabel');
        }

        $this->fieldName = $fieldName;
        $this->label = $label;
        $this->attributes = $options + $this->defaultOptions;
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        $output = '';
        if ($this->hiddenField) {
            $output = Helper::getInstance()
                ->hidden($this->fieldName, [self::ATTRIBUTE_VALUE => 0]);
        }
        $output .= Helper::getInstance()
            ->input(Input::INPUT_TYPE_CHECKBOX, $this->fieldName, $this->attributes);
        $output .= $this->label;

        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'attrs' => $this->templater->formatAttributes($this->attributes[self::CHECKBOX_ATTRIBUTE_CONTAINER]),
                'label' => Helper::getInstance()->label($output, $this->attributes[self::CHECKBOX_ATTRIBUTE_LABEL]),
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::CHECKBOX_ATTRIBUTE_CONTAINER,
            self::CHECKBOX_ATTRIBUTE_LABEL,
        ]);
    }
}
