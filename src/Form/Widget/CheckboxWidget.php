<?php

/**
 * CheckboxWidget.php
 *
 * Checkbox widget with label and input element
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
 * Class CheckboxWidget
 * @package Brnbio\LaravelForm\Form\Widget
 */
class CheckboxWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<div class="form-check">{{control}}{{label}}</div>';

    /**
     * CheckboxWidget constructor.
     * @param string $fieldName
     * @param array $attributes
     */
    public function __construct(string $fieldName, array $attributes = [])
    {
        if (empty($attributes[self::ATTRIBUTE_LABEL])) {
            $attributes[self::ATTRIBUTE_LABEL] = [];
        } else {
            if (!is_array($attributes[self::ATTRIBUTE_LABEL])) {
                $attributes[self::ATTRIBUTE_LABEL] = [
                    self::ATTRIBUTE_LABEL_TEXT => $attributes[self::ATTRIBUTE_LABEL],
                ];
            }
        }

        $attributes[self::ATTRIBUTE_LABEL] += [
            Element\Label::ATTRIBUTE_CLASS => 'form-check-label',
        ];

        parent::__construct($fieldName, $attributes);
    }

    /**
     * @return AbstractElement
     */
    protected function getControl(): AbstractElement
    {
        $inputAttributes = $this->attributes + [
            Element\Input::ATTRIBUTE_TYPE => Element\Input::INPUT_TYPE_CHECKBOX,
            Element\Input::ATTRIBUTE_CLASS => 'form-check-input',
        ];

        return new Element\Input($this->fieldName, $inputAttributes);
    }
}
