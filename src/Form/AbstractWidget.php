<?php

/**
 * AbstractWidget.php
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-10-04
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use Brnbio\LaravelForm\Template\StringTemplate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Class AbstractWidget
 * @package Brnbio\LaravelForm\Form
 */
abstract class AbstractWidget
{
    /**
     * Widget attributes
     */
    public const ATTRIBUTE_LABEL = 'label';
    public const ATTRIBUTE_CONTROL = 'control';
    public const ATTRIBUTE_LABEL_TEXT = 'text';
    public const ATTRIBUTE_TYPE = 'type';

    /**
     * @var AbstractElement[]
     */
    protected $elements = [];

    /**
     * @var StringTemplate
     */
    protected $templater;

    /**
     * Widget wrapper default template
     *
     * @var string
     */
    protected $defaultTemplate = '<div class="form-group">{{label}}{{control}}</div>';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * AbstractWidget constructor.
     * @param string $fieldName
     * @param array $attributes
     */
    public function __construct(string $fieldName, array $attributes = [])
    {
        $this->templater = new StringTemplate();
        $this->fieldName = $fieldName;
        $this->attributes = $attributes;

        if (empty($this->attributes[AbstractElement::ATTRIBUTE_ID])) {
            $this->attributes[AbstractElement::ATTRIBUTE_ID] = Str::slug($fieldName);
        }

        $this->generateElements();
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return (string)config('laravel-form.templates.' . static::class) ?: $this->defaultTemplate;
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        foreach ($this->elements as &$element) {
            $element = $element->render();
        }

        return $this->templater
            ->formatTemplate($this->getTemplate(), $this->elements);
    }

    /**
     * @return Element\Label
     */
    protected function getLabel(): Element\Label
    {
        $labelText = Str::studly($this->fieldName);
        $labelAttributes = [
            'for' => $this->attributes[AbstractElement::ATTRIBUTE_ID] ?? null,
        ];

        // -- label attributes is only the label content as string
        if (isset($this->attributes[self::ATTRIBUTE_LABEL])
            && !is_array($this->attributes[self::ATTRIBUTE_LABEL])) {
            $labelText = $this->attributes[self::ATTRIBUTE_LABEL];
            unset($this->attributes[self::ATTRIBUTE_LABEL]);
        }

        // -- label attributes is an array, text key contains the content
        if (isset($this->attributes[self::ATTRIBUTE_LABEL])
            && is_array($this->attributes[self::ATTRIBUTE_LABEL])) {

            // -- strip label content
            if (isset($this->attributes[self::ATTRIBUTE_LABEL][self::ATTRIBUTE_LABEL_TEXT])) {
                $labelText = $this->attributes[self::ATTRIBUTE_LABEL][self::ATTRIBUTE_LABEL_TEXT];
                unset($this->attributes[self::ATTRIBUTE_LABEL][self::ATTRIBUTE_LABEL_TEXT]);
            }

            // -- merge label attributes
            $labelAttributes = $this->attributes[self::ATTRIBUTE_LABEL] + $labelAttributes;
            unset($this->attributes[self::ATTRIBUTE_LABEL]);
        }

        return new Element\Label($labelText, $labelAttributes);
    }

    /**
     * @return AbstractWidget
     */
    protected function generateElements(): self
    {
        $this->elements['label'] = $this->getLabel();
        $this->elements['control'] = $this->getControl();

        return $this;
    }

    /**
     * @return AbstractElement
     */
    abstract protected function getControl(): AbstractElement;

}
