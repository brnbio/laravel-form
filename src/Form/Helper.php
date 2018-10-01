<?php

/**
 * Helper.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use Brnbio\LaravelForm\Form\Element as Element;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

/**
 * Class Form
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm
 */
class Helper
{
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
     * @param Model|null $context
     * @param array $options
     * @return HtmlString
     */
    public function create(?Model $context = null, array $options = []): HtmlString
    {
        if ($context !== null) {
            $this->context = new Context($context);
        }

        return (new Element\FormStart($options))
            ->render();
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
     * @param array  $options
     *
     * @return HtmlString
     */
    public function control(string $fieldName, array $options = []): HtmlString
    {
        if ($this->getContext() === null) {
            throw new \Exception('No context set in form helper.');
        }
        $type = $this->getControlType($fieldName);
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function label(string $text, array $options = []): HtmlString
    {
        return (new Element\Label($text, $options))
            ->render();
    }

    /**
     * @param string $type
     * @param string $fieldName
     * @param array  $options
     *
     * @return HtmlString
     */
    public function input(string $type, string $fieldName, array $options = []): HtmlString
    {
        $options[Element\Input::ATTRIBUTE_TYPE] = $type;

        return (new Element\Input($fieldName, $options))
            ->render();
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function text(string $fieldName, array $options = []): HtmlString
    {
        if (! isset($options[Element\Input::ATTRIBUTE_VALUE])) {
            $options[Element\Input::ATTRIBUTE_VALUE] = old($fieldName, e($this->getValue($fieldName)));
        }

        return $this->input(
            Element\Input::INPUT_TYPE_TEXT,
            $fieldName,
            $options
        );
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function hidden(string $fieldName, array $options = []): HtmlString
    {
        return $this->input(
            Element\Input::INPUT_TYPE_HIDDEN,
            $fieldName,
            $options
        );
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function email(string $fieldName, array $options = []): HtmlString
    {
        return $this->input(
            Element\Input::INPUT_TYPE_EMAIL,
            $fieldName,
            $options
        );
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function checkbox(string $fieldName, array $options = []): HtmlString
    {
        return (new Element\Checkbox($fieldName, $options))
            ->render();
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function button(string $text, array $options = []): HtmlString
    {
        return (new Element\Button($text, $options))
            ->render();
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function reset(string $text, array $options = []): HtmlString
    {
        $options[Element\Button::ATTRIBUTE_TYPE] = Element\Button::BUTTON_TYPE_RESET;

        return $this->button($text, $options);
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function submit(string $text, array $options = []): HtmlString
    {
        $options[Element\Button::ATTRIBUTE_TYPE] = Element\Button::BUTTON_TYPE_SUBMIT;

        return $this->button($text, $options);
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
            return $this->getContext()
                ->getEntity()
                ->getAttribute($fieldName);
        }

        return null;
    }

    /**
     * @param string $fieldName
     *
     * @return string
     */
    private function getControlType(string $fieldName): string
    {
        $type = $this->getMetadata($fieldName);

        dd($fieldName, $type);
    }
}
