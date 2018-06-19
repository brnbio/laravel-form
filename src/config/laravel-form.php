<?php

/**
 * laravel-form.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

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

        /*'string' => 'text',
        'text' => 'textarea',
        'uuid' => 'string',
        'datetime' => 'datetime',
        'timestamp' => 'datetime',
        'date' => 'date',
        'time' => 'time',
        'boolean' => 'checkbox',
        'float' => 'number',
        'integer' => 'number',
        'tinyinteger' => 'number',
        'smallinteger' => 'number',
        'decimal' => 'number',
        'binary' => 'file',*/
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
        \Brnbio\LaravelForm\Form\Element\Control::class     => '<div{{attrs}}>{{label}}{{control}}</div>',
        \Brnbio\LaravelForm\Form\Element\FormStart::class   => '<form{{attrs}}>{{csrf}}',
        \Brnbio\LaravelForm\Form\Element\FormEnd::class     => '</form>',
        \Brnbio\LaravelForm\Form\Element\Label::class       => '<label{{attrs}}>{{text}}</label>',







        'button' => '<button{{attrs}}>{{text}}</button>',
        'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
        'checkboxFormGroup' => '{{label}}',
        'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
        'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
        'error' => '<div class="error-message">{{content}}</div>',
        'errorList' => '<ul>{{content}}</ul>',
        'errorItem' => '<li>{{text}}</li>',
        'file' => '<input type="file" name="{{name}}"{{attrs}}>',
        'fieldset' => '<fieldset{{attrs}}>{{content}}</fieldset>',

        'formEnd' => '</form>',
        'formGroup' => '{{label}}{{input}}',
        'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}}/>',
        'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
        'inputContainer' => '<div{{attrs}}>{{label}}{{control}}</div>',
        'inputContainerError' => '<div class="form-group {{type}}{{required}} error">{{label}}{{control}}{{error}}</div>',

        'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
        'legend' => '<legend>{{text}}</legend>',
        'multicheckboxTitle' => '<legend>{{text}}</legend>',
        'multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
        'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
        'selectMultiple' => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
        'radioWrapper' => '{{label}}',
        'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
        'submitContainer' => '<div class="submit">{{content}}</div>',
    ]

];
