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
use Brnbio\LaravelForm\Template\StringTemplate;
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
     * @var StringTemplate
     */
    protected $templater;

    /**
     * @var Context|null
     */
    protected $context = null;

    /**
     * Helper constructor.
     * Init template engine
     *
     */
    public function __construct()
    {
        $this->templater = new StringTemplate();
    }

    /**
     * @return Helper
     */
    public static function getInstance(): Helper
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @return StringTemplate
     */
    public function templater(): StringTemplate
    {
        return $this->templater;
    }

    /**
     * @param string $fieldName
     * @param array $options
     * @return HtmlString
     */
    public function control(string $fieldName, array $options = []): HtmlString
    {
        $element = new Element\Control($fieldName, $options, $this->getMetadata($fieldName));
        $label = $this->label($options['label'] ?? ucfirst($fieldName), [
            'for' => $fieldName,
        ]);

        return $this->templater()->formatTemplate($element->getTemplate(), [
            'label' => $label,
            'control' => null,
            'attrs' => $this->templater()->formatAttributes($element->getAttributes()),
        ]);
    }

    /**
     * @param Model|null $context
     * @param array $options
     * @return HtmlString
     */
    public function create(Model $context = null, array $options = []): HtmlString
    {
        if (null !== $context) {
            $this->context = new Context($context);
        }

        $element = new Element\FormStart($options);
        $placeholders = [
            'attrs' => $this->templater()->formatAttributes($element->getAttributes()),
            'csrf' => csrf_field(),
        ];

        return $this->templater()->formatTemplate($element->getTemplate(), $placeholders);
    }

    /**
     * @return HtmlString
     */
    public function end(): HtmlString
    {
        $this->context = null;
        $element = new Element\FormEnd();

        return $this->templater()->formatTemplate($element->getTemplate());
    }

    /**
     * @param string $text
     * @param array $options
     * @return HtmlString
     */
    public function label(string $text, array $options = []): HtmlString
    {
        $element = new Element\Label($text, $options);

        return $this->templater()->formatTemplate($element->getTemplate(), [
            'text' => $text,
            'attrs' => $this->templater()->formatAttributes($element->getAttributes()),
        ]);
    }

    /**
     * @param string $fieldName
     * @return array
     */
    private function getMetadata(string $fieldName): array
    {
        return ($this->context instanceof Context) ? $this->context->getMetadata($fieldName) : [];
    }
}
