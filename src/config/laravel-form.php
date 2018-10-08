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
        'button' => 'btn btn-primary',
        'checkbox' => 'form-check-input',
        'error' => 'error',
        'input' => 'form-control',
        'required' => 'required',
        'select' => 'form-control',
    ],

    /*
    |--------------------------------------------------------------------------
    | Typemap
    |--------------------------------------------------------------------------
    |
    | This option maps the database metadata to a control type. If context
    | is set, the mapping try to get the control type for the field name
    |
    | Custom types are:
    | - datetime => 6 select elements: {{day}}{{month}}{{year}}{{hour}}{{minute}}{{seconds}}
    | - date => 3 select elements: {{day}}{{month}}{{year}}
    | - time => 3 select elements: {{hour}}{{minute}}{{seconds}}
    |
    */

    'typeMap' => [
        'string'        => 'input:text',
        'text'          => 'textarea',
        'uuid'          => 'input:text',
        'datetime'      => 'datetime',
        'timestamp'     => 'datetime',
        'date'          => 'date',
        'time'          => 'time',
        'boolean'       => 'input:checkbox',
        'float'         => 'input:number',
        'integer'       => 'input:number',
        'tinyinteger'   => 'input:number',
        'smallinteger'  => 'input:number',
        'decimal'       => 'input:number',
        'binary'        => 'input:file',
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

        /*
        |--------------------------------------------------------------------------
        | Basic elements
        |--------------------------------------------------------------------------
        |
        | Templates for the ingle basic elements
        |
        */

        \Brnbio\LaravelForm\Form\Element\Button::class      => '<button{{attrs}}>{{text}}</button>',
        \Brnbio\LaravelForm\Form\Element\FormStart::class   => '<form{{attrs}}>{{csrf}}',
        \Brnbio\LaravelForm\Form\Element\FormEnd::class     => '</form>',
        \Brnbio\LaravelForm\Form\Element\Input::class       => '<input name="{{name}}"{{attrs}}/>',
        \Brnbio\LaravelForm\Form\Element\Label::class       => '<label{{attrs}}>{{text}}</label>',
        \Brnbio\LaravelForm\Form\Element\Select::class      => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
        \Brnbio\LaravelForm\Form\Element\Option::class      => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        \Brnbio\LaravelForm\Form\Element\Textarea::class    => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',

        /*
        |--------------------------------------------------------------------------
        | Widgets
        |--------------------------------------------------------------------------
        |
        | Templates for widgets which contains a wrapper and the elements inside
        |
        */

        \Brnbio\LaravelForm\Form\Widget\Control::class      => '<div class="form-group">{{content}}</div>'

        /*
        // Widget ordering for date/time/datetime pickers.
        'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
        // Fieldset element used by allControls().
        'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        // General grouping container for control(). Defines input/label ordering.
        'formGroup' => '{{label}}{{input}}',
        // Wrapper content used to hide other content.
        'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
        // Submit input element.
        'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
        // Container element used by control().
        'inputContainer' => '<div class="input {{type}}{{required}}">{{content}}</div>',
        // Legends created by allControls()
        'legend' => '<legend>{{text}}</legend>',
        // Radio input element,
        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',

        */

    ],
];
