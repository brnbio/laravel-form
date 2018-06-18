<?php

/**
 * AbstractElement.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Form;

/**
 * Class AbstractElement
 *
 * @package Brnbio\LaravelForm
 * @subpackage Form
 */
class AbstractElement
{
    /**
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * @var string
     */
    protected $defaultTemplate = '';

    /**
     * @var array
     */
    protected $allowedAttributes = [];

    /**
     * @var array
     */
    protected $allowedAttributeValues = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        /** @var string $template */
        if ($template = config(self::class)) {
            return $template;
        }

        return $this->defaultTemplate;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function validateAttributes(array $options = []): array
    {
        foreach ($options as $key => $value) {
            if (!in_array($key, $this->allowedAttributes)) {
                unset($options[$key]);
            } else {
                if (false === $this->validateAttributeValue($key, $options[$key])) {
                    unset($options[$key]);
                }
            }
        }

        return $options;
    }

    /**
     * @param string $key
     * @param string|null $value
     * @return bool
     */
    private function validateAttributeValue(string $key, string $value = null): bool
    {
        if (empty($this->allowedAttributeValues[$key])) {
            return true;
        }

        return !empty($value) && in_array($value, $this->allowedAttributeValues[$key]);
    }
}
