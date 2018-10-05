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
    protected $defaultTemplate = '<div class="form-group"{{attrs}}>{{content}}</div>';

    /**
     * @var string
     */
    protected $type = 'text';

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

        if (isset($attributes[self::ATTRIBUTE_TYPE])) {
            $this->type = $attributes[self::ATTRIBUTE_TYPE];
            unset($attributes[self::ATTRIBUTE_TYPE]);
        }

        $this->fieldName = $fieldName;
        $this->attributes = $attributes;

        // -- TODO: if type is another widget type like (date or checkbox), return this widget

        /**
         * Switch behavior by type
         */
        switch ($this->type) {
            // -- checkbox elements are wrapped into labels
            case 'checkbox':

                break;
            case 'text':
                $this->elements = $this->text();
                break;
            // default elements like "normal" input elements with the common structure (div/label/control)
            default:
                // -- add label only if not set as false
                if (!(isset($this->attributes[self::ATTRIBUTE_LABEL])
                    && $this->attributes[self::ATTRIBUTE_LABEL] === false)) {
                    $this->elements[] = $this->addLabel();
                }
        }
    }

    /**
     * @return AbstractElement[]
     */
    protected function text(): array
    {
        $text = Str::studly($this->fieldName);
        $labelAttributes = [
            'for' => Str::slug($this->fieldName),
        ];

        // -- label attributes is only the label content as string
        if (isset($this->attributes[self::ATTRIBUTE_LABEL])
            && !is_array($this->attributes[self::ATTRIBUTE_LABEL])) {
            $text = $this->attributes[self::ATTRIBUTE_LABEL];
        }

        // -- label attributes is an array, text key contains the content
        if (isset($this->attributes[self::ATTRIBUTE_LABEL])
            && is_array($this->attributes[self::ATTRIBUTE_LABEL])) {

            // -- strip label content
            if (isset($this->attributes[self::ATTRIBUTE_LABEL][self::ATTRIBUTE_LABEL_TEXT])) {
                $text = $this->attributes[self::ATTRIBUTE_LABEL][self::ATTRIBUTE_LABEL_TEXT];
                unset($this->attributes[self::ATTRIBUTE_LABEL][self::ATTRIBUTE_LABEL_TEXT]);
            }

            // -- merge label attributes
            $labelAttributes = $this->attributes[self::ATTRIBUTE_LABEL] + $labelAttributes;
        }

        /**
         * label attributes can be a string (label text only) or an array
         * with the label attributes (like class, for etc.) and the key
         * "text" represents the label content
         */
        if (isset($this->attributes[self::ATTRIBUTE_LABEL])) {
            if (is_array($this->attributes[self::ATTRIBUTE_LABEL])) {

            } else {
                $text = $this->attributes[self::ATTRIBUTE_LABEL];
            }
        }

        return new Element\Label($text, $labelAttributes);
    }
}
