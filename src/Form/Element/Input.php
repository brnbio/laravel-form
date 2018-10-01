<?php

/**
 * Input.php
 *
 * The input element represents a one-line plain text edit control for the input element’s value.
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-22
 * @link        https://www.w3.org/TR/2010/WD-html-markup-20100624/input.html
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;

/**
 * Class Input
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm\Form\Element
 */
class Input extends AbstractElement
{
    public const INPUT_TYPE_CHECKBOX = 'checkbox';
    public const INPUT_TYPE_EMAIL = 'email';
    public const INPUT_TYPE_FILE = 'file';
    public const INPUT_TYPE_HIDDEN = 'hidden';
    public const INPUT_TYPE_NUMBER = 'number';
    public const INPUT_TYPE_PASSWORD = 'password';
    public const INPUT_TYPE_RADIO = 'radio';
    public const INPUT_TYPE_TEXT = 'text';
    public const INPUT_TYPE_URL = 'url';

    /**
     * @var mixed[]
     */
    protected $defaultOptions = [
        self::ATTRIBUTE_TYPE => self::INPUT_TYPE_TEXT,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<input name="{{name}}"{{attrs}} />';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    protected $type;

    /**
     * Input constructor.
     *
     * @param string $fieldName
     * @param array $options
     */
    public function __construct(string $fieldName, array $options = [])
    {
        parent::__construct();

        if (! isset($options[self::ATTRIBUTE_CLASS])) {
            $options[self::ATTRIBUTE_CLASS] = config('laravel-form.css.input');
        }

        $this->fieldName = $fieldName;
        $this->attributes = $this->validateAttributes($options + $this->defaultOptions, [
            self::ATTRIBUTE_NAME,
        ]);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'name' => $this->fieldName,
                'attrs' => $this->templater->formatAttributes($this->attributes),
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_VALUE,
        ]);
    }
}
