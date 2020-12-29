<?php

/**
 * Input.php
 *
 * The input element represents a one-line plain text edit control for the input element’s value.
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-22
 * @link        https://www.w3.org/TR/html5/sec-forms.html#the-input-element
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class Input
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm\Form\Element
 */
class Input extends AbstractElement
{
    public const INPUT_TYPE_CHECKBOX = 'checkbox';
    public const INPUT_TYPE_DATE = 'date';
    public const INPUT_TYPE_DATETIME_LOCAL = 'datetime-local';
    public const INPUT_TYPE_EMAIL = 'email';
    public const INPUT_TYPE_FILE = 'file';
    public const INPUT_TYPE_HIDDEN = 'hidden';
    public const INPUT_TYPE_NUMBER = 'number';
    public const INPUT_TYPE_PASSWORD = 'password';
    public const INPUT_TYPE_RADIO = 'radio';
    public const INPUT_TYPE_TEXT = 'text';
    public const INPUT_TYPE_URL = 'url';

    /**
     * @var mixed[]
     */
    protected $defaultAttributes = [
        self::ATTRIBUTE_TYPE => self::INPUT_TYPE_TEXT,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<input name="{{name}}"{{attrs}} />';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * Add hidden field to prevent that no value is set
     *
     * @var bool
     */
    protected $hiddenField = true;

    /**
     * Input constructor.
     *
     * @param string $fieldName
     * @param array $attributes
     */
    public function __construct(string $fieldName, array $attributes = [])
    {
        parent::__construct();

        if (! isset($attributes[self::ATTRIBUTE_CLASS])) {
            $attributes[self::ATTRIBUTE_CLASS] = config('laravel-form.css.input');
        }

        if ( isset($attributes['hiddenField']) && $attributes['hiddenField'] === false) {
            $this->hiddenField = false;
        }

        $this->fieldName = $fieldName;
        $this->attributes = $this->validateAttributes($attributes + $this->defaultAttributes);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        $hiddenField = '';

        dd($this->attributes);


        if ($this->attributes[self::ATTRIBUTE_TYPE] === self::INPUT_TYPE_CHECKBOX && $this->hiddenField) {
            $element = new Input($this->fieldName, [
                self::ATTRIBUTE_TYPE => self::INPUT_TYPE_HIDDEN,
                self::ATTRIBUTE_VALUE => 0,
            ]);
            $hiddenField .= $element->render();
        }

        return $this->templater
            ->formatTemplate($hiddenField . $this->getTemplate(), [
                'name' => $this->fieldName,
                'attrs' => $this->templater->formatAttributes($this->attributes),
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_ACCEPT,
            self::ATTRIBUTE_ALT,
            self::ATTRIBUTE_AUTOCOMPLETE,
            self::ATTRIBUTE_AUTOFOCUS,
            self::ATTRIBUTE_CHECKED,
            self::ATTRIBUTE_DIRNAME,
            self::ATTRIBUTE_DISABLED,
            self::ATTRIBUTE_FORM,
            self::ATTRIBUTE_FORM_ACTION,
            self::ATTRIBUTE_FORM_ENCTYPE,
            self::ATTRIBUTE_FORM_METHOD,
            self::ATTRIBUTE_FORM_NO_VALIDATE,
            self::ATTRIBUTE_FORM_TARGET,
            self::ATTRIBUTE_HEIGHT,
            self::ATTRIBUTE_LIST,
            self::ATTRIBUTE_MAX,
            self::ATTRIBUTE_MAXLENGTH,
            self::ATTRIBUTE_MIN,
            self::ATTRIBUTE_MINLENGTH,
            self::ATTRIBUTE_MULTIPLE,
            self::ATTRIBUTE_NAME,
            self::ATTRIBUTE_PATTERN,
            self::ATTRIBUTE_PLACEHOLDER,
            self::ATTRIBUTE_READONLY,
            self::ATTRIBUTE_REQUIRED,
            self::ATTRIBUTE_SIZE,
            self::ATTRIBUTE_SRC,
            self::ATTRIBUTE_TYPE,
            self::ATTRIBUTE_VALUE,
            self::ATTRIBUTE_WIDTH,
        ]);
    }

    /**
     * @param array $attributesValues
     *
     * @return void
     */
    protected function addAdditionalAllowedAttributesValues(array $attributesValues = []): void
    {
        parent::addAdditionalAllowedAttributesValues([
            self::ATTRIBUTE_AUTOCOMPLETE => [
                self::ATTRIBUTE_VALUE_ON,
                self::ATTRIBUTE_VALUE_OFF,
            ],
            self::ATTRIBUTE_TYPE => [
                self::INPUT_TYPE_CHECKBOX,
                self::INPUT_TYPE_DATE,
                self::INPUT_TYPE_DATETIME_LOCAL,
                self::INPUT_TYPE_EMAIL,
                self::INPUT_TYPE_FILE,
                self::INPUT_TYPE_HIDDEN,
                self::INPUT_TYPE_NUMBER,
                self::INPUT_TYPE_PASSWORD,
                self::INPUT_TYPE_RADIO,
                self::INPUT_TYPE_TEXT,
                self::INPUT_TYPE_URL,
            ],
        ]);
    }
}
