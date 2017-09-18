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
     * @var bool
     */
    protected $inLumen = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        if ($this->app instanceof \Laravel\Lumen\Application) {
            $this->inLumen = true;

            $this->app->configure('app');

            unset($this->app->availableBindings['translator']);
        }

        parent::register();

        $this->registerCommands();
    }

    /**
     * Register the translation line loader.
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            $paths = [
                base_path('vendor/broqiang/laravel-lang/src/'),
            ];

            if ($this->inLumen) {
                $this->app['path.lang'] = base_path('vendor/laravel/lumen-framework/resources/lang');
                array_push($paths, base_path('resources/lang/'));
            }

            return new FileLoader($app['files'], $app['path.lang'], $paths);
        });
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
