<?php

declare(strict_types=1);

namespace Translator\Infra;

use Translator\Infra\Exception\InvalidTranslationFile;
use Translator\Infra\Exception\TranslationFileDoesNotExistForLanguage;
use Translator\Infra\Exception\UnableToSaveTranslationKeyAlreadyExists;
use Translator\Translator\ConfigLoader;
use Translator\Translator\Translation;
use Translator\Translator\TranslationRepository;

class LaravelJsonTranslationRepository implements TranslationRepository
{
    private ConfigLoader $config;

    /** @var array<string, array<string>> */
    private array $fileCache = [];

    public function __construct(ConfigLoader $config)
    {
        $this->config = $config;
    }

    /**
     * @throws TranslationFileDoesNotExistForLanguage
     * @throws InvalidTranslationFile
     */
    public function exists(Translation $translation, string $language): bool
    {
        $translations = $this->getTranslations($language);

        return isset($translations[$translation->getKey()]);
    }

    /**
     * @throws InvalidTranslationFile
     * @throws TranslationFileDoesNotExistForLanguage
     * @throws UnableToSaveTranslationKeyAlreadyExists
     */
    public function save(Translation $translation, string $language): void
    {
        $translations = $this->getTranslations($language);

        if ($this->exists($translation, $language)) {
            throw new UnableToSaveTranslationKeyAlreadyExists($translation, $language);
        }

        $translations[$translation->getKey()] = $translation->getKey();

        $this->fileCache[$language] = $translations;

        $this->writeFile($language);
    }

    /**
     * @throws TranslationFileDoesNotExistForLanguage
     * @throws InvalidTranslationFile
     * @return array<string>
     */
    private function getTranslations(string $language): array
    {
        if (! isset($this->fileCache[$language])) {
            $this->fileCache[$language] = $this->readFile($language);
        }

        return $this->fileCache[$language];
    }

    private function getFileNameForLanguage(string $language): string
    {
        $directory = $this->config->output();

        return $directory."/{$language}.json";
    }

    /**
     * @return string[]
     * @throws InvalidTranslationFile
     * @throws TranslationFileDoesNotExistForLanguage
     */
    private function readFile(string $language): array
    {
        $filename = $this->getFileNameForLanguage($language);

        if (! file_exists($filename)) {
            throw new TranslationFileDoesNotExistForLanguage($language);
        }

        $content = file_get_contents($filename);

        if (! $content) {
            throw new InvalidTranslationFile($language);
        }

        $translations = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidTranslationFile($language);
        }

        return $translations;
    }

    private function writeFile(string $language): void
    {
        $content = $this->fileCache[$language];
        ksort($content);

        file_put_contents(
            $this->getFileNameForLanguage($language),
            json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}
