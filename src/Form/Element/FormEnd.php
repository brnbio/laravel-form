<?php

/**
 * FormEnd.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;

/**
 * Class FormEnd
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class FormEnd extends AbstractElement
{
    /**
     * @var string
     */
    protected $defaultTemplate = '</form>';

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater->formatTemplate($this->getTemplate());
    }
}
