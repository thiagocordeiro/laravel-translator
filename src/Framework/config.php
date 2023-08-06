<?php declare(strict_types=1);
  
  use Translator\Framework\LaravelConfigLoader;
  use Translator\Infra\LaravelJsonTranslationRepository;
  
  return [
    'languages' => ['en', 'pt-br', 'es'],
    'default_language' => 'en',
    'directories' => [
      app_path(),
      resource_path('views'),
    ],
    'output' => resource_path('lang'),
    'modules' => true,
    'modules_output' => false,
    'modules_dir' => base_path('Modules'),
    'extensions' => ['php'],
    'functions' => ['lang', '__'],
    'container' => [
      'config_loader' => LaravelConfigLoader::class,
      'translation_repository' => LaravelJsonTranslationRepository::class,
    ],
    'use_keys_as_default_value' => true,
  ];