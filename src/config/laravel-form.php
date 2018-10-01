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
        'string' => 'text',
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
        'binary' => 'file',
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
        // Used for button elements in button().
        \Brnbio\LaravelForm\Form\Element\Button::class => '<button{{attrs}}>{{text}}</button>',

        // Open tag used by create().
        \Brnbio\LaravelForm\Form\Element\FormStart::class => '<form{{attrs}}>',

        // Close tag used by end().
        \Brnbio\LaravelForm\Form\Element\FormEnd::class => '</form>',

        // Generic input element.
        \Brnbio\LaravelForm\Form\Element\Input::class => '<input name="{{name}}"{{attrs}}/>',

        // Label element when inputs are not nested inside the label.
        \Brnbio\LaravelForm\Form\Element\Label::class => '<label{{attrs}}>{{text}}</label>',

        // Used for checkboxes in checkbox()
        \Brnbio\LaravelForm\Form\Element\Checkbox::class => '{{hiddenField}}<input type="checkbox" name="{{name}}"{{attrs}}/>',

        /*

        'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
        // Input group wrapper for checkboxes created via control().
        'checkboxFormGroup' => '{{label}}',
        // Wrapper container for checkboxes.
        'checkboxWrapper' => '<div class="checkbox">{{label}}</div>',
        // Widget ordering for date/time/datetime pickers.
        'dateWidget' => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
        // Error message wrapper elements.
        'error' => '<div class="error-message">{{content}}</div>',
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
        // Container element used by control() when a field has an error.
        'inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}{{error}}</div>',
        // Label element when inputs are not nested inside the label.
        'label' => '<label{{attrs}}>{{text}}</label>',
        // Label element used for radio and multi-checkbox inputs.
        'nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
        // Legends created by allControls()
        'legend' => '<legend>{{text}}</legend>',
        // Multi-Checkbox input set title element.
        'multicheckboxTitle' => '<legend>{{text}}</legend>',
        // Multi-Checkbox wrapping container.
        'multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>',
        // Option element used in select pickers.
        'option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
        // Option group element used in select pickers.
        'optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
        // Select element,
        'select' => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
        // Multi-select element,
        'selectMultiple' => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
        // Radio input element,
        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
        // Wrapping container for radio input/label,
        'radioWrapper' => '{{label}}',
        // Textarea input element,
        'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>',
        // Container for submit buttons.
        'submitContainer' => '<div class="submit">{{content}}</div>',*/
    ],

    /*'templates' => [
         => '<button{{attrs}}>{{text}}</button>',

        \Brnbio\LaravelForm\Form\Element\Control::class => '<div{{attrs}}>{{label}}{{control}}</div>',
         => '</form>',
         => '<form{{attrs}}>{{csrf}}',
         => '<input type="{{type}}" name="{{name}}"{{attrs}} />',

    ],*/

];
