<?php

/**
 * Select.php
 *
 * @copyright   OEMUS MEDIA AG (https://oemus.com)
 * @author      Frank Heider <f.heider@oemus-media.de>
 * @since       02.10.2018
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form\Element;

use Brnbio\LaravelForm\Form\AbstractElement;
use Illuminate\Support\HtmlString;

/**
 * Class Select
 *
 * @package    Brnbio\LaravelForm
 * @subpackage Form\Element
 */
class Select extends AbstractElement
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<select name="{{name}}"{{attrs}}>{{content}}</select>';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Option[]
     */
    protected $options = [];

    /**
     * Select constructor.
     *
     * @param string $fieldName
     * @param array  $options
     * @param array  $attributes
     */
    public function __construct(string $fieldName, array $options = [], array $attributes = [])
    {
        parent::__construct();

        // -- init option elements
        foreach ($options as $value => $option) {
            // -- add selected attribute if value of select is value of this option
            $optionAttributes = [];
            if (isset($attributes[self::ATTRIBUTE_VALUE])
                && $attributes[self::ATTRIBUTE_VALUE] == $value) {
                $optionAttributes[] = self::ATTRIBUTE_SELECTED;
            }
            // -- option is given as array with value and additional attributes
            if (is_array($option)) {
                $this->options[] = new Option($value, (string)$option['text'], $optionAttributes + $option['attributes']);
            // -- option is given as simple text
            } else {
                $this->options[] = new Option($value, (string)$option, $optionAttributes);
            }
        }

        // -- insert empty element if select is not multiple
        if (isset($attributes['empty']) && ! in_array(self::ATTRIBUTE_MULTIPLE, $attributes)) {
            array_unshift($this->options, new Option(null, $attributes['empty']));
            unset($attributes['empty']);
        }

        // -- css class
        if (! isset($attributes[self::ATTRIBUTE_CLASS])) {
            $attributes[self::ATTRIBUTE_CLASS] = config('laravel-form.css.select');
        }

        // -- multiple name if not even set
        if (in_array(self::ATTRIBUTE_MULTIPLE, $attributes) && substr($fieldName, -2, 2) != '[]') {
            $fieldName .= '[]';
        }

        $this->name = trim($fieldName);
        $this->attributes = $this->validateAttributes($attributes);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        $content = '';
        foreach ($this->options as $option) {
            $content .= $option->render();
        }

        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'name' => $this->name,
                'attrs' => $this->templater->formatAttributes($this->attributes),
                'content' => $content,
            ]);
    }

    /**
     * @param array $attributes
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_MULTIPLE,
            self::ATTRIBUTE_REQUIRED,
        ]);
    }
}
