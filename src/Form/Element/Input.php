<?php

/**
 * Input.php
 *
 * @copyright   OEMUS MEDIA AG (https://oemus.com)
 * @author      Frank Heider <f.heider@oemus-media.de>
 * @since       22.06.2018
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
    /**
     * @var string
     */
    protected $defaultTemplate = '<input type="{{type}}" name="{{name}}"{{attrs}} />';

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
     * @param string $type
     * @param string $fieldName
     * @param array $options
     */
    public function __construct(string $type, string $fieldName, array $options = [])
    {
        parent::__construct();

        $this->type = $type;
        $this->fieldName = $fieldName;
        $this->attributes = $this->validateAttributes($options + $this->defaultOptions, [
            self::ATTRIBUTE_TYPE,
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
                'type' => $this->type,
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
