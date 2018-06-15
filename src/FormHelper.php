<?php

/**
 * Form.php
 *
 * @copyright   OEMUS MEDIA AG (https://oemus.com)
 * @author      Frank Heider <f.heider@oemus-media.de>
 * @since       15.06.2018
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm;

/**
 * Class Form
 *
 * @package laravel
 * @subpackage Brnbio\LaravelForm
 */
class FormHelper
{
    protected static $instance;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public function create($method = 'post')
    {
        return sprintf('<form method="%s">', $method);
    }
}
