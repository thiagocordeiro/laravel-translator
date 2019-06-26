<?php declare(strict_types=1);

namespace Translator\Framework;

use Illuminate\Support\ServiceProvider;
use Translator\Application\ConfigLoader;
use Translator\Sentence\SentenceRepository;

class TranslatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([TranslatorCommand::class]);
        }

        $this->setupConfigs();
        $this->setupContainer();
    }

    private function setupConfigs(): void
    {
        $name = 'translator';
        $default = __DIR__."/../../config/{$name}.php";
        $custom = base_path("config/{$name}.php");

        $this->mergeConfigFrom($default, $name);
        $this->publishes([$default => $custom], 'config');
    }

    private function setupContainer(): void
    {
        $this->app->bind(ConfigLoader::class, config('translator.container.config_loader'));
        $this->app->bind(SentenceRepository::class, config('translator.container.sentence_repository'));
    }
}
