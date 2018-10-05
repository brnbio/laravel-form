<?php

/**
 * AbstractWidget.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-10-04
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

use Brnbio\LaravelForm\Template\StringTemplate;
use Illuminate\Support\HtmlString;

/**
 * Class AbstractWidget
 *
 * @package    Brnbio\LaravelForm
 * @subpackage Form
 */
abstract class AbstractWidget
{
    /**
     * Widget attributes
     */
    public const ATTRIBUTE_LABEL = 'label';
    public const ATTRIBUTE_LABEL_TEXT = 'text';
    public const ATTRIBUTE_TYPE = 'type';

    /**
     * @var AbstractElement[]
     */
    protected $elements = [];

    /**
     * @var StringTemplate
     */
    protected $templater;

    /**
     * Widget wrapper default template
     *
     * @var string
     */
    protected $defaultTemplate = '{{content}}';

    /**
     * AbstractWidget constructor.
     */
    public function __construct()
    {
        $this->templater = new StringTemplate();
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return (string)config('laravel-form.templates.' . static::class) ?: $this->defaultTemplate;
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        $content = '';
        foreach ($this->elements as $element) {
            $content .= $element->render();
        }

        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'content' => $content,
            ]);
    }
}
