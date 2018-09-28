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
     * @param string $fieldName
     * @param string $label
     * @param array $options
     * @return HtmlString
     */
    public function checkbox(string $fieldName, string $label, array $options = []): HtmlString
    {
        return (new Element\Checkbox($fieldName, $label, $options))
            ->render();
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function control(string $fieldName, array $options = []): HtmlString
    {
        die('TODO');
        /*return $this
            ->getElementByName('control', $fieldName, $options, $this->getMetadata($fieldName))
            ->render();*/
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
     * @param array $options
     * @return HtmlString
     */
    public function hidden(string $fieldName, array $options = []): HtmlString
    {
        $element = new Element\Input(
            Element\Input::INPUT_TYPE_HIDDEN,
            $fieldName,
            $options
        );

        return $element->render();
    }

    /**
     * @param string $type
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function input(string $type, string $fieldName, array $options = []): HtmlString
    {
        return $this
            ->getElementByName('input', $type, $fieldName, $options)
            ->render();
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function label(string $text, array $options = []): HtmlString
    {
        return $this
            ->getElementByName('label', $text, $options)
            ->render();
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function reset(string $text, array $options = []): HtmlString
    {
        $options[Button::ATTRIBUTE_TYPE] = Button::BUTTON_TYPE_RESET;

        return $this
            ->getElementByName('button', $text, $options)
            ->render();
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function submit(string $text, array $options = []): HtmlString
    {
        $options[Button::ATTRIBUTE_TYPE] = Button::BUTTON_TYPE_SUBMIT;

        return $this
            ->getElementByName('button', $text, $options)
            ->render();
    }

    /**
     * @param string $fieldName
     * @return array
     */
    private function getMetadata(string $fieldName): array
    {
        return $this->context instanceof Context
            ? $this->context->getMetadata($fieldName)
            : [];
    }
}
