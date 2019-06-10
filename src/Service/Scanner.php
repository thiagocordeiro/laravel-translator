<?php declare(strict_types=1);

namespace Translator\Service;

use Exception;
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

        if (!is_array($directories)) {
            throw new Exception('Invalid directories configuration');
        }

        foreach ($directories as $directory) {
            $allKeys = array_merge($allKeys, $this->scanDirectory($directory));
        }

        ksort($allKeys);

        return $allKeys;
    }

    /**
     * @return string[]
     */
    private function scanDirectory(string $path): array
    {
        $files = glob_recursive("{$path}/*.php", GLOB_BRACE);
        $keys = [];

        foreach ($files as $file) {
            $content = $this->getSanitizedContent($file);

            $keys = array_merge(
                $keys,
                $this->getTranslationKeysFromFunction('lang', $content),
                $this->getTranslationKeysFromFunction('__', $content)
            );
        }

        return $keys;
    }

    private function getSanitizedContent(string $filePath): string
    {
        $content = (string) file_get_contents($filePath) ?? '';

        return str_replace("\n", ' ', $content);
    }

    /**
     * @return string[]
     */
    private function getTranslationKeysFromFunction(string $functionName, string $content): array
    {
        preg_match_all("#{$functionName}\((.*?)\)#", $content, $matches);

        if (empty($matches) || empty($matches[1])) {
            return [];
        }

        $keys = [];

        foreach ($matches[1] as $match) {
            preg_match('#\'(.*?)\'#', $match, $strings);

            if (empty($strings)) {
                continue;
            }

            $keys[$strings[1]] = $strings[1];
        }

        return $keys;
    }
}
