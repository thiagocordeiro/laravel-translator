<?php

namespace Translator;

use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Translator\Command\Translator::class,
            ]);
        }

        $this->mergeConfigFrom(__DIR__ . '/config/laravel-translator.php', 'laravel-translator');

        $this->publishes([
            __DIR__ . '/config/laravel-translator.php' => base_path('config/laravel-translator.php'),
        ], 'config');
    }
}
