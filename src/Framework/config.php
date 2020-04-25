<?php declare(strict_types=1);

use Translator\Framework\LaravelConfigLoader;
use Translator\Infra\LaravelJsonTranslationRepository;

return [
    'languages' => ['pt-br', 'es'],
    'scannable_files' => 'php', //php,vue
    'directories' => [
        app_path(),
        resource_path('views'),
    ],
    'output' => resource_path('lang'),
    'container' => [
        'config_loader' => LaravelConfigLoader::class,
        'translation_repository' => LaravelJsonTranslationRepository::class,
    ],
];
