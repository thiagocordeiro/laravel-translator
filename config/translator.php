<?php declare(strict_types=1);

use Translator\Application\LocalJsonSentenceRepository;
use Translator\Framework\LaravelConfigLoader;

return [
    'languages' => ['pt-br', 'es'],
    'directories' => [
        app_path(),
        resource_path('views'),
    ],
    'output' => resource_path('lang'),
    'container' => [
        'config_loader' => LaravelConfigLoader::class,
        'sentence_repository' => LocalJsonSentenceRepository::class,
    ],
];
