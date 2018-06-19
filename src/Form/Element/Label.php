<?php

/**
 * Label.php
 *
 * Caption for a form control.
 *
 * Permitted attributes:
 * - common attributes
 * - for
 * - form
 *
 * Tag omission:
 * A label element must have both a start tag and an end tag.
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/label.html
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;

/**
 * Class Label
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class Label extends AbstractElement
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<label{{attrs}}>{{text}}</label>';

    /**
     * @var string
     */
    protected $text;

    /**
     * Label constructor
     *
     * @param string $text
     * @param array $options
     */
    public function __construct(string $text, array $options = [])
    {
        parent::__construct();
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

    /**
     * @return void
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            'for',
            'form',
        ]);
    }
}
