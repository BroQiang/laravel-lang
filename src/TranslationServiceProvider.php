<?php

/*
 * This file is part of the BroQiang/laravel-lang.
 */

namespace BroQiang\LaravelLang;

use Illuminate\Translation\TranslationServiceProvider as LaravelTranslationServiceProvider;
use BroQiang\LaravelLang\Commands\Publish as PublishCommand;

class TranslationServiceProvider extends LaravelTranslationServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerCommands();
    }

    /**
     * Register lang:publish command.
     */
    protected function registerCommands()
    {
        $this->commands(PublishCommand::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array_merge(parent::provides(), [PublishCommand::class]);
    }
}
