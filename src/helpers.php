<?php

/**
 * helpers.php
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

if (! function_exists('form')) {
    /**
     * Get the available container instance.
     *
     * @return \Brnbio\LaravelForm\Form\Helper
     */
    function form(): \Brnbio\LaravelForm\Form\Helper
    {
        return \Brnbio\LaravelForm\Form\Helper::getInstance();
    }
}
