<?php

/**
 * laravel-form.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | CSS
    |--------------------------------------------------------------------------
    |
    | This option controls the default css class names for different control
    | types and containers.
    |
    */

    'css' => [
        'checkbox' => 'form-check-input',
        'checkboxContainer' => 'form-check',
        'checkboxLabel' => 'form-check-label',
        'error' => 'error',
        'input' => 'form-control',
        'inputContainer' => 'form-group',
        'required' => 'required',
    ],

    /*
    |--------------------------------------------------------------------------
    | Typemap
    |--------------------------------------------------------------------------
    |
    | This option maps the database metadata to a control type. If context
    | is set, the mapping try to get the control type for the field name
    |
    */

    'typeMap' => [
        'varchar' => 'text',
        'longtext' => 'textarea',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    | This option contain all possible templates
    |
    */

    'templates' => [
        \Brnbio\LaravelForm\Form\Element\Button::class => '<button{{attrs}}>{{text}}</button>',
        \Brnbio\LaravelForm\Form\Element\Checkbox::class => '<div{{attrs}}>{{label}}</div>',
        \Brnbio\LaravelForm\Form\Element\Control::class => '<div{{attrs}}>{{label}}{{control}}</div>',
        \Brnbio\LaravelForm\Form\Element\FormEnd::class => '</form>',
        \Brnbio\LaravelForm\Form\Element\FormStart::class => '<form{{attrs}}>{{csrf}}',
        \Brnbio\LaravelForm\Form\Element\Input::class => '<input type="{{type}}" name="{{name}}"{{attrs}} />',
        \Brnbio\LaravelForm\Form\Element\Label::class => '<label{{attrs}}>{{text}}</label>',
    ],

];
