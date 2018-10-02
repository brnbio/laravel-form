<?php

/**
 * Option.php
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
 * Class Option
 *
 * @package    Brnbio
 * @subpackage Brnbio\LaravelForm\Form\Element
 */
class Option extends AbstractElement
{
    /**
     * @var string
     */
    protected $defaultTemplate = '<option value="{{value}}"{{attrs}}>{{text}}</option>';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $text;

    /**
     * Option constructor.
     *
     * @param        $value
     * @param string $text
     * @param array  $attributes
     */
    public function __construct($value, string $text, array $attributes = [])
    {
        parent::__construct();
        $this->value = $value;
        $this->text = trim($text);
        $this->attributes = $this->validateAttributes($attributes);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        return $this->templater
            ->formatTemplate($this->getTemplate(), [
                'value' => $this->value,
                'text' => $this->text,
                'attrs' => $this->templater->formatAttributes($this->attributes),
            ]);
    }

    /**
     * @param array $attributes
     *
     * @return void
     */
    protected function addAdditionalAllowedAttributes(array $attributes = []): void
    {
        parent::addAdditionalAllowedAttributes([
            self::ATTRIBUTE_SELECTED,
        ]);
    }
}
