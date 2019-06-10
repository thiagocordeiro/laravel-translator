<?php declare(strict_types=1);

namespace Translator\Service;

class FileHandler
{
    /**
     * @param string[] $keys
     * @return string[]
     */
    public function handle(array $keys, string $file): array
    {
        $translationData = $this->getAlreadyTranslatedKeys($file);
        $newKeys = [];

        foreach ($keys as $key) {
            if (isset($translationData[$key])) {
                continue;
            }

            $translationData[$key] = '';
            $newKeys[] = $key;
        }

        if (empty($newKeys)) {
            return [];
        }

        $this->writeNewTranslationFile($file, $translationData);

        return $newKeys;
    }

    /**
     * @return string[]
     */
    private function getAlreadyTranslatedKeys(string $filePath): array
    {
        $fileContent = trim(file_get_contents($filePath));

        if (empty($fileContent)) {
            return [];
        }

        $current = json_decode($fileContent, true);
        ksort($current);

        return $current;
    }

    /**
     * @param string[] $translations
     */
    private function writeNewTranslationFile(string $filePath, array $translations): void
    {
        file_put_contents($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
