<?php declare(strict_types=1);

namespace Translator\Framework;

use Illuminate\Support\ServiceProvider;
use Translator\Translator\ConfigLoader;
use Translator\Translator\TranslationRepository;

/**
 * @codeCoverageIgnore
 */
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
        $default = __DIR__."/config.php";
        $custom = base_path("config/translator.php");

        $this->mergeConfigFrom($default, 'translator');
        $this->publishes([$default => $custom], 'config');
    }

    private function setupContainer(): void
    {
        $this->app->bind(ConfigLoader::class, config('translator.container.config_loader'));
        $this->app->bind(TranslationRepository::class, config('translator.container.translation_repository'));
    }
}
