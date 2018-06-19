<?php

/**
 * FormServiceProvider.php
 *
 * @copyright   Copyright (c) brainbo UG (haftungsbeschränkt) (http://brnb.io)
 * @author      Frank Heider <heider@brnb.io>
 * @since       2018-06-18
 */

declare(strict_types=1);

namespace Brnbio\LaravelForm;

use Illuminate\Support\ServiceProvider;

/**
 * Class FormServiceProvider
 *
 * @package Brnbio\LaravelForm
 */
class FormServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            $this->getConfigFile() => config_path($this->getPackageName() . '.php'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            $this->getPackageName()
        );
    }

    /**
     * @return string
     */
    private function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $this->getPackageName() . '.php';
    }

    /**
     * @return string
     */
    private function getPackageName(): string
    {
        return 'laravel-form';
    }
}
