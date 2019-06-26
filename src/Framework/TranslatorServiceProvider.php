<?php declare(strict_types=1);

namespace Translator\Framework;

use Illuminate\Support\ServiceProvider;
use Translator\Sentence\SentenceRepository;

class TranslatorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([TranslatorCommand::class]);
        }

        $this->setupConfigs('translator');
    }

    private function setupConfigs(string $name): void
    {
        $default = __DIR__."/../../config/{$name}.php";
        $custom = base_path("config/{$name}.php");

        $this->mergeConfigFrom($default, $name);
        $this->publishes([$default => $custom], 'config');

        $this->app->bind(SentenceRepository::class, config('translator.sentence_repository'));
    }
}
