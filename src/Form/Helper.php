<?php

/**
 * Helper.php
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use Brnbio\LaravelForm\Form\Element as Element;
use Brnbio\LaravelForm\Form\Widget as Widget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ViewErrorBag;

/**
 * Class Helper
 * @package Brnbio\LaravelForm\Form
 */
class Helper
{
    public const CONTROL_TYPE_TEXT = 'text';
    public const CONTROL_TYPE_TEXTAREA = 'textarea';
    public const CONTROL_TYPE_SELECT = 'select';
    public const CONTROL_TYPE_PASSWORD = 'password';
    public const CONTROL_TYPE_CHECKBOX = 'checkbox';
    public const CONTROL_TYPE_EMAIL = 'email';
    public const CONTROL_TYPE_NUMBER = 'number';
    public const CONTROL_TYPE_DATE = 'date';
    public const CONTROL_TYPE_DATETIME = 'datetime';

    /**
     * @var Helper
     */
    protected static $instance;

    /**
     * @var Context|null
     */
    protected $context = null;

    /**
     * @return Helper
     */
    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param string $text
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function button(string $text, array $attributes = []): HtmlString
    {
        return (new Element\Button($text, $attributes))
            ->render();
    }

    /**
     * @param string $fieldName
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function checkbox(string $fieldName, array $attributes = []): HtmlString
    {
        $attributes += [
            Element\Input::ATTRIBUTE_CLASS => config('laravel-form.css.checkbox'),
        ];
        $checkbox = $this->input(Element\Input::INPUT_TYPE_CHECKBOX, $fieldName, $attributes);

        return new HtmlString($checkbox);
    }

    /**
     * @param string $fieldName
     * @param array $attributes
     * @return HtmlString
     */
    public function control(string $fieldName, array $attributes = []): HtmlString
    {
        $metadata = $this->getMetadata($fieldName);
        $attributes += [
            'type' => $this->getType($fieldName),
        ];

        $fieldErrors = [];
        $errors = session()->get('errors');
        if (!empty($errors) && $errors->get($fieldName)) {
            $fieldErrors = $errors->get($fieldName);
        }

        if ($metadata['required'] ?? false) {
            $attributes[] = 'required';
        }

        if ($attributes['type'] === 'checkbox') {
            $default = $this->getValue($fieldName) ?: ($metadata['default'] ?? false);
            if (old($fieldName, $default)) {
                $attributes[] = 'checked';
            }
        }

        // -- try to add a value if nothing is set
        if (!isset($attributes[Element\Input::ATTRIBUTE_VALUE])
            && $attributes['type'] !== Element\Input::INPUT_TYPE_CHECKBOX
            && $attributes['type'] !== Element\Input::INPUT_TYPE_PASSWORD) {
            $attributes[Element\Input::ATTRIBUTE_VALUE] = old($fieldName, e($this->getValue($fieldName)));
        }

        switch ($attributes['type']) {
            case 'select':
                return (new Widget\SelectWidget($fieldName, $attributes, $fieldErrors))
                    ->render();
                break;
            case 'textarea':
                return (new Widget\TextareaWidget($fieldName, $attributes, $fieldErrors))
                    ->render();
                break;
            case 'checkbox':
                return (new Widget\CheckboxWidget($fieldName, $attributes, $fieldErrors))
                    ->render();
                break;
        }

        return (new Widget\InputWidget($fieldName, $attributes, $fieldErrors))
            ->render();
    }

    /**
     * @param Model|null $context
     * @param array $attributes
     * @return HtmlString
     */
    public function create(?Model $context = null, array $attributes = []): HtmlString
    {
        if ($context !== null) {
            $this->context = new Context($context);
        }

        return (new Element\FormStart($attributes))
            ->render();
    }

    /**
     * @param string $fieldName
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function email(string $fieldName, array $attributes = []): HtmlString
    {
        return $this->input(
            Element\Input::INPUT_TYPE_EMAIL,
            $fieldName,
            $attributes
        );
    }

    /**
     * @return HtmlString
     */
    public function end(): HtmlString
    {
        $this->context = null;

        return (new Element\FormEnd())
            ->render();
    }

    /**
     * @param string $fieldName
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function hidden(string $fieldName, array $attributes = []): HtmlString
    {
        $attributes += [
            Element\Input::ATTRIBUTE_STYLE => 'display:none;',
            Element\Input::ATTRIBUTE_CLASS => 'hidden',
        ];

        return $this->input(
            Element\Input::INPUT_TYPE_HIDDEN,
            $fieldName,
            $attributes
        );
    }

    /**
     * @param string $type
     * @param string $fieldName
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function input(string $type, string $fieldName, array $attributes = []): HtmlString
    {
        $attributes[Element\Input::ATTRIBUTE_TYPE] = $type;

        return (new Element\Input($fieldName, $attributes))
            ->render();
    }

    /**
     * @param string $text
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function label(string $text, array $attributes = []): HtmlString
    {
        return (new Element\Label($text, $attributes))
            ->render();
    }

    /**
     * @param string $text
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function reset(string $text, array $attributes = []): HtmlString
    {
        $attributes[Element\Button::ATTRIBUTE_TYPE] = Element\Button::BUTTON_TYPE_RESET;

        return $this->button($text, $attributes);
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function select(string $fieldName, $options = [], array $attributes = []): HtmlString
    {
        return (new Element\Select($fieldName, $options, $attributes))
            ->render();
    }

    /**
     * @param string $text
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function submit(string $text, array $attributes = []): HtmlString
    {
        $attributes[Element\Button::ATTRIBUTE_TYPE] = Element\Button::BUTTON_TYPE_SUBMIT;

        return $this->button($text, $attributes);
    }

    /**
     * @param string $fieldName
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function text(string $fieldName, array $attributes = []): HtmlString
    {
        return $this->input(
            Element\Input::INPUT_TYPE_TEXT,
            $fieldName,
            $attributes
        );
    }

    /**
     * Create an textarea element
     *
     * @param string $fieldName
     * @param array $attributes
     *
     * @return HtmlString
     */
    public function textarea(string $fieldName, array $attributes = []): HtmlString
    {
        return (new Element\Textarea($fieldName, $attributes))
            ->render();
    }

    /**
     * @return Context|null
     */
    protected function getContext(): ?Context
    {
        return $this->context;
    }

    /**
     * @param string $fieldName
     *
     * @return array
     */
    private function getMetadata(string $fieldName): array
    {
        if ($this->getContext()) {
            return $this->getContext()->getMetadata($fieldName);
        }

        return [];
    }

    /**
     * @param string $fieldName
     *
     * @return string|null
     */
    private function getValue(string $fieldName): ?string
    {
        if ($this->getContext()) {
            return (string) $this->getContext()
                ->getEntity()
                ->getAttribute($fieldName);
        }

        return null;
    }

    /**
     * @param string $fieldName
     * @return string
     */
    private function getType(string $fieldName): string
    {
        $metadata = $this->getMetadata($fieldName);
        $result = self::CONTROL_TYPE_TEXT;

        // -- type by column type
        if (!empty($metadata['type'])) {
            switch ($metadata['type']) {
                case 'text':
                case 'tinytext':
                case 'mediumtext':
                case 'longtext':
                    $result = self::CONTROL_TYPE_TEXTAREA;
                    break;
                case 'date':
                    $result = self::CONTROL_TYPE_DATE;
                    break;
                case 'datetime':
                    $result = self::CONTROL_TYPE_DATETIME;
                    break;
                case 'int':
                case 'integer':
                case 'tinyint':
                case 'smallint':
                case 'bigint':
                case 'mediumint':
                    $result = $metadata['maxlength'] === 1 ? self::CONTROL_TYPE_CHECKBOX : self::CONTROL_TYPE_NUMBER;
                    break;
            }
        }

        // -- sounds like there is a password
        if (strpos($fieldName, 'password') !== false) {
            $result = self::CONTROL_TYPE_PASSWORD;
        }

        // -- field names with ending '_id' seems to be a relationship
        if (preg_match('/_id$/', $fieldName)) {
            $result = self::CONTROL_TYPE_SELECT;
        }

        // -- email
        if ($fieldName === 'email') {
            $result = self::CONTROL_TYPE_EMAIL;
        }

        return $result;
    }
}
