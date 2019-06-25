<?php declare(strict_types=1);

namespace Translator\Sentence;

use Exception;

class Scanner
{
    public function scan(string ...$directories): SentenceCollection
    {
        if (!is_array($directories)) {
            throw new Exception('Invalid directories configuration');
        }

        $collection = new SentenceCollection();

        foreach ($directories as $directory) {
            $collection->push(...$this->scanDirectory($directory));
        }

        return $collection;
    }

    /**
     * @return Sentence[]
     */
    private function scanDirectory(string $path): array
    {
        $files = glob_recursive("{$path}/*.php", GLOB_BRACE);
        $sentences = [];

        foreach ($files as $file) {
            $content = $this->getSanitizedContent($file);

            $sentences = array_merge(
                $sentences,
                $this->getTranslationKeysFromFunction('lang', $content),
                $this->getTranslationKeysFromFunction('__', $content)
            );
        }

        return $sentences;
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

        $sentences = [];

        foreach ($matches[1] as $match) {
            preg_match('#\'(.*?)\'#', $match, $strings);

            if (empty($strings)) {
                continue;
            }

            $sentences[] = new Sentence($strings[1], '');
        }

        return $sentences;
    }
}
