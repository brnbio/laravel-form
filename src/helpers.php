<?php

if (! function_exists('form')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return \Brnbio\LaravelForm\Form\Helper
     */
    function form()
    {
        return \Brnbio\LaravelForm\Form\Helper::getInstance();
    }
}