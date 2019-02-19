<?php

/**
 * StringTemplate.php
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm\Template;

use Illuminate\Support\HtmlString;

/**
 * Class String
 *
 * @package Brnbio\LaravelForm
 * @subpackage Template
 */
class StringTemplate
{
    /**
     * @param string $template
     * @param array $placeholders
     * @return HtmlString
     */
    public function formatTemplate(string $template, array $placeholders = []): HtmlString
    {
        foreach ($placeholders as $key => $value) {
            $template = str_replace('{{' . $key . '}}', '' . $value, $template);
        }
        $template = preg_replace('#\{\{([\w\._]+)\}\}#', '', $template);

        return new HtmlString($template);
    }

    /**
     * @param array $options
     * @param array $exclude
     * @return string
     */
    public function formatAttributes(array $options = [], array $exclude = []): string
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            if (! in_array($key, $exclude, true)) {
                $attributes[] = $this->formatAttribute($key, $value);
            }
        }

        return empty($attributes) ? '' : ' ' . trim(implode(' ', $attributes));
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return string
     */
    private function formatAttribute(string $key, $value): string
    {
        if ($key === $value) {
            return $value;
        }

        if (is_array($value)) {
            $value = implode(' ', $value);
        }

        return $key . '="' . e($value) . '"';
    }
}
