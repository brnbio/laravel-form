<?php

/**
 * SelectWidget.php
 *
 * Select widget with label and select element
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
 * Class SelectWidget
 * @package Brnbio\LaravelForm\Form\Widget
 */
class SelectWidget extends AbstractWidget
{
    /**
     * @return AbstractElement
     */
    protected function getControl(): AbstractElement
    {
        $options = $this->attributes['options'] ?? [];
        unset($this->attributes['options']);

        $attributes = $this->attributes + [
            'empty' => '---',
            Element\Input::ATTRIBUTE_CLASS => config('laravel-form.css.input'),
        ];

        if (isset($attributes['empty']) && $attributes['empty'] === false) {
            unset($attributes['empty']);
        }

        if (!empty($this->fieldErrors)) {
            $attributes[Element\Input::ATTRIBUTE_CLASS] .= ' ' . config('laravel-form.css.invalid');
        }

        return new Element\Select($this->fieldName, $options, $attributes);
    }
}
