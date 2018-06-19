<?php

/**
 * FormStart.php
 *
 * The form element represents a user-submittable form.
 *
 * Permitted attributes
 * - common attributes
 * - action
 * - method
 * - enctype
 * - name
 * - accept-charset
 * - novalidate
 * - target
 * - autocomplete
 *
 * Tag omission:
 * A form element must have both a start tag and an end tag.
 * (end tag > Brnbio\LaravelForm\Form\Element\FormEnd)
 *
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/form.html
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
     * FormStart constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct();
        $options += $this->defaultOptions;

        if (isset($options['type']) && 'file' === $options['type']) {
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

    /**
     * @return void
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            'accept-charset',
            'action',
            'autocomplete',
            'enctype',
            'method',
            'novalidate',
            'target',
        ]);
    }

    /**
     * @param array $attributesValues
     * @return void
     */
    protected function addAdditionalAllowedAttributesValues(array $attributesValues = []): void
    {
        parent::addAdditionalAllowedAttributesValues([
            'autocomplete' => [
                'on',
                'off',
            ],
            'enctype' => [
                'application/x-www-form-urlencoded',
                'multipart/form-data',
                'text/plain',
            ],
            'method' => [
                'get',
                'post',
                'put',
                'delete',
            ],
            'target' => [
                '_blank',
                '_self',
                '_parent',
                '_top',
            ],
        ]);
    }
}
