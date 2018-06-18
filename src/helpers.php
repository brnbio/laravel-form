<?php

if (! function_exists('form')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $abstract
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function form()
    {
        return \Brnbio\LaravelForm\Form\Helper::getInstance();
    }
}