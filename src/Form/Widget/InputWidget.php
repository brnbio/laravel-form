<?php

/**
 * InputWidget.php
 *
 * Input widget with label and input element
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2019-02-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Widget;

use Brnbio\LaravelForm\Form\AbstractElement;
use Brnbio\LaravelForm\Form\AbstractWidget;
use Brnbio\LaravelForm\Form\Element as Element;

/**
 * Class InputWidget
 * @package Brnbio\LaravelForm\Form\Widget
 */
class InputWidget extends AbstractWidget
{
    /**
     * @return AbstractElement
     */
    protected function getControl(): AbstractElement
    {
        $inputAttributes = $this->attributes + [
            Element\Input::ATTRIBUTE_TYPE => Element\Input::INPUT_TYPE_TEXT,
            Element\Input::ATTRIBUTE_CLASS => config('laravel-form.css.input'),
        ];

        if (!empty($this->fieldErrors)) {
            $inputAttributes[Element\Input::ATTRIBUTE_CLASS] .= ' ' . config('laravel-form.css.invalid');
        }

        return new Element\Input($this->fieldName, $inputAttributes);
    }
}
