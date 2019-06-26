<?php declare(strict_types=1);

use Translator\Application\LocalJsonSentenceRepository;

return [
    'directories' => [
        app_path(),
        resource_path('views'),
    ],
    'translations_output' => resource_path('lang'),
    'sentence_repository' => LocalJsonSentenceRepository::class,
];
