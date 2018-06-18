<?php

/**
 * Label.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;

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
     * @var array
     */
    protected $allowedAttributes = [
        'for',
        'class',
    ];

    /**
     * Label constructor
     *
     * @param string $text
     * @param array $options
     */
    public function __construct(string $text, array $options = [])
    {
        $this->attributes = $this->validateAttributes($options);
    }
}
