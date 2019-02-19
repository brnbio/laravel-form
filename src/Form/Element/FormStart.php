<?php

/**
 * FormStart.php
 *
 * The form element represents a user-submittable form.
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 * @link        https://www.w3.org/TR/html/sec-forms.html#the-form-element
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
    public const FORM_METHOD_GET = 'get';
    public const FORM_METHOD_POST = 'post';
    public const FORM_METHOD_PUT = 'put';
    public const FORM_METHOD_DELETE = 'delete';

    public const FORM_ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    public const FORM_ENCTYPE_FILE = 'multipart/form-data';
    public const FORM_ENCTYPE_PLAIN = 'text/plain';

    /**
     * @var array
     */
    protected $defaultOptions = [
        self::ATTRIBUTE_METHOD => self::FORM_METHOD_POST,
        self::ATTRIBUTE_ACCEPT_CHARSET => 'utf-8',
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

        if (isset($options[self::ATTRIBUTE_TYPE]) && $options[self::ATTRIBUTE_TYPE] === 'file') {
            $options[self::ATTRIBUTE_ENCTYPE] = self::FORM_ENCTYPE_FILE;
        }

        $this->attributes = $this->validateAttributes($options);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'attrs' => $this->templater->formatAttributes($this->attributes),
                'csrf' => csrf_field(),
            ]);
    }

    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_ACCEPT_CHARSET,
            self::ATTRIBUTE_ACTION,
            self::ATTRIBUTE_AUTOCOMPLETE,
            self::ATTRIBUTE_ENCTYPE,
            self::ATTRIBUTE_METHOD,
            self::ATTRIBUTE_NO_VALIDATE,
            self::ATTRIBUTE_TARGET,
        ]);
    }

    /**
     * @param array $attributesValues
     */
    protected function addAdditionalAllowedAttributesValues(array $attributesValues = []): void
    {
        parent::addAdditionalAllowedAttributesValues([
            self::ATTRIBUTE_AUTOCOMPLETE => [
                self::ATTRIBUTE_VALUE_ON,
                self::ATTRIBUTE_VALUE_OFF,
            ],
            self::ATTRIBUTE_ENCTYPE => [
                self::FORM_ENCTYPE_DEFAULT,
                self::FORM_ENCTYPE_FILE,
                self::FORM_ENCTYPE_PLAIN,
            ],
            self::ATTRIBUTE_METHOD => [
                self::FORM_METHOD_GET,
                self::FORM_METHOD_POST,
                self::FORM_METHOD_PUT,
                self::FORM_METHOD_DELETE,
            ],
            self::ATTRIBUTE_TARGET => [
                self::TARGET_BLANK,
                self::TARGET_PARENT,
                self::TARGET_SELF,
                self::TARGET_TOP,
            ],
        ]);
    }
}
