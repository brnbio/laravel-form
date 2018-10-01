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
    /**
     * @var array
     */
    protected $defaultOptions = [
        self::ATTRIBUTE_VALUE => 1,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '{{hiddenField}}<input type="checkbox" name="{{name}}"{{attrs}}/>';

    /**
     * @var string
     */
    protected $fieldName;

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
    public function __construct(string $fieldName, array $options = [])
    {
        parent::__construct();

        if (isset($options['hiddenField'])) {
            $this->hiddenField = (bool)$options['hiddenField'];
            unset($options['hiddenField']);
        }

        if (! isset($options[self::ATTRIBUTE_CLASS])) {
            $options[self::ATTRIBUTE_CLASS] = config('laravel-form.css.checkbox');
        }

        $this->fieldName = $fieldName;
        $this->attributes = $options + $this->defaultOptions;
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        // -- add hidden field with value 0 to force sending the given field to request
        $hiddenField = null;
        if ($this->hiddenField) {
            $hiddenField = new Input(
                $this->fieldName,
                [
                    self::ATTRIBUTE_TYPE => Input::INPUT_TYPE_HIDDEN,
                    self::ATTRIBUTE_VALUE => 0,
                ]
            );
        }

        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'hiddenField' => $hiddenField ? $hiddenField->render() : '',
                'attrs' => $this->templater->formatAttributes($this->attributes, [
                    self::ATTRIBUTE_NAME,
                    self::ATTRIBUTE_TYPE,
                ]),
                'name' => $this->fieldName,
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_VALUE,
        ]);
    }
}
