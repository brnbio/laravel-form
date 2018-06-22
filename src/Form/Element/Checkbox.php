<?php

/**
 * Checkbox.php
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
 * Class Checkbox
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm\Form\Element
 */
class Checkbox extends AbstractElement
{
    /**
     * @var array
     */
    protected $defaultOptions = [
        'value' => 1,
    ];

    /**
     * @var string
     */
    protected $defaultTemplate = '<input type="checkbox" name="{{name}}"{{attrs}}>';

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * Insert a hidden input field to definitly set a value to this field
     *
     * @var bool
     */
    protected $hiddenField = true;

    /**
     * Checkbox constructor.
     * @param string $fieldName
     * @param array $options
     */
    public function __construct(string $fieldName, array $options = [])
    {
        parent::__construct();

        if (isset($options['hiddenField'])) {
            $this->hiddenField = (bool)$options['hiddenField'];
        }

        $this->fieldName = $fieldName;
        $this->attributes = $this->validateAttributes($options + $this->defaultOptions, [
            self::ATTRIBUTE_NAME,
            self::ATTRIBUTE_TYPE,
        ]);
    }

    /**
     * @return HtmlString
     */
    public function render(): HtmlString
    {
        $hiddenField = '';
        if ($this->hiddenField) {
            $hiddenField = (new Input('hidden', $this->fieldName, ['value' => 0]))->render();
        }

        return $this->templater->formatTemplate($hiddenField . $this->getTemplate(), [
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
