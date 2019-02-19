<?php

/**
 * Label.php
 *
 * Caption for a form control.
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 * @link        https://www.w3.org/TR/html/sec-forms.html#the-label-element
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
     * @param array $attributes
     */
    public function __construct(string $text, array $attributes = [])
    {
        parent::__construct();
        $this->text = trim($text);
        $this->attributes = $this->validateAttributes($attributes);
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
            self::ATTRIBUTE_FOR,
        ]);
    }
}
