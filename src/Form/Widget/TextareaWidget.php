<?php

/**
 * TextareaWidget.php
 *
 * Textarea widget with label and input element
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
 * Class TextareaWidget
 * @package Brnbio\LaravelForm\Form\Widget
 */
class TextareaWidget extends AbstractWidget
{
    /**
     * @return AbstractElement
     */
    protected function getControl(): AbstractElement
    {
        return new Element\Textarea($this->fieldName, $this->attributes);
    }
}
