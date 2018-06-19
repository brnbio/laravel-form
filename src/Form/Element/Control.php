<?php

/**
 * Control.php
 *
 * A special div container which include a label element and an input element.
 *
 * Permitted attributes:
 * - common attributes
 *
 * Tag omission:
 * A div element must have both a start tag and an end tag.
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/div.html
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Class Control
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class Control extends AbstractElement
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<div{{attrs}}>{{label}}{{control}}</div>';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $control;

    /**
     * @var array
     */
    protected $metadata = [];

    /**
     * Control constructor
     *
     * @param string $fieldName
     * @param array $options
     * @param array $metadata
     */
    public function __construct(string $fieldName, array $options = [], array $metadata = [])
    {
        parent::__construct();

        $options += $this->defaultOptions;

        if (!isset($options['class'])) {
            $options['class'] = config('laravel-form.css.inputContainer');
            if (!empty($metadata['type'])) {
                $options['class'] .= ' ' . $metadata['type'];
            }
            if (!empty($metadata['required'])) {
                $options['class'] .= ' ' . config('laravel-form.css.required');
            }
        }

        if (!isset($options['label'])) {
            $options['label'] = Str::camel($fieldName);
        }

        $this->fieldName = $fieldName;
        $this->label = $options['label'];
        $this->metadata = $metadata;
        $this->attributes = $this->validateAttributes($options);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater->formatTemplate($this->getTemplate(), [
            'label' => $this->renderLabel($this->label),
            'control' => null,
            'attrs' => $this->templater->formatAttributes($this->getAttributes())
        ]);
    }

    /**
     * @param string|null $label
     * @return string
     */
    private function renderLabel(string $label = null): HtmlString
    {
        if (null === $label) {
            return new HtmlString('');
        }

        return (new Label($label, ['for' => $this->fieldName]))
            ->render();
    }
}
