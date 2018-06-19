<?php

/**
 * FormStart.php
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
 * Class FormStart
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class FormStart extends AbstractElement
{
    /**
     * @var array
     */
    protected $defaultOptions = [
        'method' => 'post',
        'accept-charset' => 'utf-8',
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<form{{attrs}}>{{csrf}}';

    /**
     * @var array
     */
    protected $allowedAttributes = [
        'accept-charset',
        'action',
        'autocomplete',
        'class',
        'enctype',
        'method',
        'name',
        'novalidate',
        'target',
    ];

    /**
     * @var array
     */
    protected $allowedAttributeValues = [
        'autocomplete' => ['on', 'off'],
        'enctype' => ['application/x-www-form-urlencoded', 'multipart/form-data', 'text/plain'],
        'method' => ['get', 'post'],
        'target' => ['_blank', '_self', '_parent', '_top'],
    ];

    /**
     * FormStart constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct();

        $options += $this->defaultOptions;

        if ('file' === $options['method']) {
            $options['enctype'] = 'multipart/form-data';
        }

        $this->attributes = $this->validateAttributes($options);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater->formatTemplate($this->getTemplate(), [
            'attrs' => $this->templater->formatAttributes($this->attributes),
            'csrf' => csrf_field(),
        ]);
    }
}
