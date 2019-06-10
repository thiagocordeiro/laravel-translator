<?php declare(strict_types=1);

namespace Translator\Service;

use Translator\Config\ConfigLoader;

class Scanner
{
    /** @var ConfigLoader */
    private $config;

    public function __construct(ConfigLoader $config)
    {
        $this->config = $config;
    }

    /**
     * @return string[]
     */
    public function scan(): array
    {
        $allKeys = [];
        $directories = $this->config->load('laravel-translator.directories');

        foreach ($directories as $directory) {
            $allKeys = $this->scanDirectory($directory);
        }

        ksort($allKeys);

        return $allKeys;
    }

    /**
     * @return string
     */
    private function scanDirectory(string $path): array
    {
        $files = glob_recursive("{$path}/*.php", GLOB_BRACE);
        $keys = [];

        foreach ($files as $file) {
            $content = $this->getSanitizedContent($file);

            $keys = array_merge([
                $this->getTranslationKeysFromFunction('lang', $content),
                $this->getTranslationKeysFromFunction('__', $content),
            ]);
        }

        return $keys;
    }

    private function getSanitizedContent(string $filePath): string
    {
        return str_replace("\n", ' ', file_get_contents($filePath));
    }

    /**
     * @return string[]
     */
    private function getTranslationKeysFromFunction(string $functionName, string $content): array
    {
        preg_match_all("#{$functionName}\((.*?)\)#", $content, $matches = []);

        if (empty($matches)) {
            return [];
        }

        $keys = [];

        foreach ($matches[1] as $match) {
            preg_match('#\'(.*?)\'#', str_replace('"', "'", $match), $strings = []);

            if (empty($strings)) {
                continue;
            }

            $keys[$strings[1]] = $strings[1];
        }

        return $keys;
    }
}
