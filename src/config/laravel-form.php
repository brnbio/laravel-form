<?php

/**
 * laravel-form.php
 *
 * @copyright   Copyright (c) brnbio (http://brnb.io)
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
        'invalid' => 'is-invalid',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    */
    'templates' => [

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */
        \Brnbio\LaravelForm\Form\Element\Button::class => '<button{{attrs}}>{{text}}</button>',
        \Brnbio\LaravelForm\Form\Element\FormStart::class => '<form{{attrs}}>{{csrf}}',
        \Brnbio\LaravelForm\Form\Element\FormEnd::class => '</form>',
        \Brnbio\LaravelForm\Form\Element\Input::class => '<input name="{{name}}"{{attrs}}/>',
        \Brnbio\LaravelForm\Form\Element\Label::class => '<label{{attrs}}>{{text}}</label>',
        \Brnbio\LaravelForm\Form\Element\Select::class => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
        \Brnbio\LaravelForm\Form\Element\Option::class => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        \Brnbio\LaravelForm\Form\Element\Textarea::class => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',

        /*
        |--------------------------------------------------------------------------
        | Widgets
        |--------------------------------------------------------------------------
        */
        \Brnbio\LaravelForm\Form\Widget\InputWidget::class => '<div class="form-group input-widget">{{label}}{{control}}{{errors}}</div>',
        \Brnbio\LaravelForm\Form\Widget\CheckboxWidget::class => '<div class="form-check checkbox-widget">{{control}}{{label}}</div>',
        \Brnbio\LaravelForm\Form\Widget\SelectWidget::class => '<div class="form-group select-widget">{{label}}{{control}}</div>',
        \Brnbio\LaravelForm\Form\Widget\TextareaWidget::class => '<div class="form-group textarea-widget">{{label}}{{control}}</div>',
    ],
];
