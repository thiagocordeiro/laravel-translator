<?php declare(strict_types=1);

namespace Translator\Framework;

//use Exception;

class xxx_FileHandler
{
//    /**
//     * @param string[] $keys
//     * @return string[]
//     */
//    public function handle(array $keys, string $file): array
//    {
//        $translationData = $this->getAlreadyTranslatedKeys($file);
//        $newKeys = [];
//
//        foreach ($keys as $key) {
//            if (isset($translationData[$key])) {
//                continue;
//            }
//
//            $translationData[$key] = '';
//            $newKeys[] = $key;
//        }
//
//        if (empty($newKeys)) {
//            return [];
//        }
//
//        $this->writeNewTranslationFile($file, $translationData);
//
//        return $newKeys;
//    }
//
//    /**
//     * @return string[]
//     */
//    private function getAlreadyTranslatedKeys(string $path): array
//    {
//        $content = file_get_contents($path);
//
//        if (!$content) {
//            throw new Exception('Unable to load translation file content');
//        }
//
//        $content = trim($content);
//
//        if (empty($content)) {
//            return [];
//        }
//
//        $current = json_decode($content, true);
//        ksort($current);
//
//        return $current;
//    }
//
//    /**
//     * @param string[] $translations
//     */
//    private function writeNewTranslationFile(string $filePath, array $translations): void
//    {
//        file_put_contents($filePath, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
//    }
}
