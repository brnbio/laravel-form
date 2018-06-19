<?php

/**
 * Button.php
 *
 * button with no additional semantics
 *
 * Permitted attributes:
 * - common attributes
 * - name
 * - disabled
 * - form
 * - type
 * - value
 * - autofocus
 *
 * Tag omission:
 * A button element must have both a start tag and an end tag.
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
    /**
     * @var mixed[]
     */
    protected $defaultOptions = [
        'type' => 'button',
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
     * @param array $options
     */
    public function __construct(string $text, array $options = [])
    {
        parent::__construct();
        $options += $this->defaultOptions;
        $this->text = trim($text);
        $this->attributes = $this->validateAttributes($options);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater->formatTemplate($this->getTemplate(), [
            'text' => $this->text,
            'attrs' => $this->templater->formatAttributes($this->attributes),
        ]);
    }

    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            'name',
            'disabled',
            'form',
            'type',
            'value',
            'autofocus',
        ]);
    }

    protected function addAdditionalAllowedAttributesValues(array $attributesValues = []): void
    {
        parent::addAdditionalAllowedAttributesValues([
            'type' => [
                'button',
                'reset',
                'submit',
            ],
        ]);
    }
}
