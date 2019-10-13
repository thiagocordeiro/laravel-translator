<?php declare(strict_types=1);

namespace Translator\Translator;

use Translator\Translator\Exception\InvalidDirectoriesConfiguration;

class TranslationService
{
    /** @var ConfigLoader */
    private $config;

    /** @var TranslationScanner */
    private $scanner;

    /** @var TranslationRepository */
    private $repository;

    public function __construct(ConfigLoader $config, TranslationScanner $scanner, TranslationRepository $repository)
    {
        $this->config = $config;
        $this->scanner = $scanner;
        $this->repository = $repository;
    }

    /**
     * @throws InvalidDirectoriesConfiguration
     */
    public function scanAndSaveNewKeys(): void
    {
        $directories = $this->config->directories();

        $translations = $this->scanner->scan(...$directories);

        $this->storeTranslations(...$translations);
    }

    private function storeTranslations(Translation ...$translations): void
    {
        array_map(function (Translation $translation): void {
            $this->storeTranslation($translation);
        }, $translations);
    }

    private function storeTranslation(Translation $translation): void
    {
        $languages = $this->config->languages();

        array_map(function (string $language) use ($translation): void {
            if ($this->repository->exists($translation, $language)) {
                return;
            }

            $this->repository->save($translation, $language);
        }, $languages);
    }
}
