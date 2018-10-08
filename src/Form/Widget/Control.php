<?php

/**
 * Control.php
 *
 * Form group widget with label and input element
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-10-04
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Widget;

use Brnbio\LaravelForm\Form\AbstractElement;
use Brnbio\LaravelForm\Form\AbstractWidget;
use Brnbio\LaravelForm\Form\Element as Element;
use Illuminate\Support\Str;

/**
 * Class Control
 *
 * @package    Brnbio\LaravelForm
 * @subpackage Form\Widget
 */
class Control extends AbstractWidget
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<div class="form-group">{{content}}</div>';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * Control constructor.
     *
     * @param string $fieldName
     * @param array  $attributes
     */
    public function __construct(string $fieldName, array $attributes = [])
    {
        parent::__construct();

        $this->fieldName = $fieldName;
        $this->attributes = $attributes;

        // -- add label
        $this->elements[] = $this->getLabel();
        $this->elements[] = $this->getInput();

    }

    /**
     * @return Element\Label
     */
    protected function getLabel(): Element\Label
    {
        $labelText = Str::studly($this->fieldName);
        $labelAttributes = [
            'for' => Str::slug($this->fieldName),
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
     * @return Element\Input
     */
    protected function getInput(): Element\Input
    {
        $inputAttributes = $this->attributes + [
            Element\Input::ATTRIBUTE_ID => Str::slug($this->fieldName),
            Element\Input::ATTRIBUTE_TYPE => Element\Input::INPUT_TYPE_TEXT,
        ];

        return new Element\Input($this->fieldName, $inputAttributes);
    }
}
