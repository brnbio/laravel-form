<?php

/**
 * Button.php
 *
 * button with no additional semantics
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-19
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/button.button.html
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/button.submit.html
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/button.reset.html
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;

/**
 * Class Button
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class Button extends AbstractElement
{
    public const BUTTON_TYPE_BUTTON = 'button';
    public const BUTTON_TYPE_SUBMIT = 'submit';
    public const BUTTON_TYPE_RESET = 'reset';

    /**
     * @var mixed[]
     */
    protected $defaultOptions = [
        self::ATTRIBUTE_TYPE => self::BUTTON_TYPE_BUTTON,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<button{{attrs}}>{{text}}</button>';

    /**
     * @var string
     */
    protected $text;

    /**
     * Button constructor
     *
     * @param string $text
     * @param array $attributes
     */
    public function __construct(string $text, array $attributes = [])
    {
        parent::__construct();

        if (! isset($attributes[self::ATTRIBUTE_CLASS])) {
            $attributes[self::ATTRIBUTE_CLASS] = config('laravel-form.css.button');
        }

        $this->text = trim($text);
        $this->attributes = $this->validateAttributes($attributes + $this->defaultOptions);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'text' => $this->text,
                'attrs' => $this->templater->formatAttributes($this->attributes),
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_AUTOFOCUS,
            self::ATTRIBUTE_DISABLED,
            self::ATTRIBUTE_FORM,
            self::ATTRIBUTE_NAME,
            self::ATTRIBUTE_TYPE,
            self::ATTRIBUTE_VALUE,
        ]);
    }

    /**
     * @param array $attributesValues
     */
    protected function addAdditionalAllowedAttributesValues(array $attributesValues = []): void
    {
        parent::addAdditionalAllowedAttributesValues([
            self::ATTRIBUTE_TYPE => [
                self::BUTTON_TYPE_BUTTON,
                self::BUTTON_TYPE_RESET,
                self::BUTTON_TYPE_SUBMIT,
            ],
        ]);
    }
}
