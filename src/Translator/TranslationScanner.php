<?php declare(strict_types=1);

namespace Translator\Translator;

use Translator\Translator\Exception\InvalidDirectoriesConfiguration;

class TranslationScanner
{
    /**
     * @return Translation[]
     * @throws InvalidDirectoriesConfiguration
     */
    public function scan(string ...$directories): array
    {
        if (empty($directories)) {
            throw new InvalidDirectoriesConfiguration();
        }

        return array_reduce($directories, function (array $collection, string $directory): array {
            return array_merge(
                $collection,
                $this->scanDirectory($directory)
            );
        }, []);
    }

    /**
     * @return Translation[]
     */
    private function scanDirectory(string $path): array
    {
        $files = glob_recursive("{$path}/*.php", GLOB_BRACE);

        return array_reduce($files, function (array $keys, $file): array {
            $content = $this->getFileContent($file);

            return array_merge(
                $keys,
                $this->getKeysFromFunction('lang', $content),
                $this->getKeysFromFunction('__', $content)
            );
        }, []);
    }

    private function getFileContent(string $filePath): string
    {
        $content = (string) file_get_contents($filePath) ?? '';

        return str_replace("\n", ' ', $content);
    }

    /**
     * @return string[]
     */
    private function getKeysFromFunction(string $functionName, string $content): array
    {
        preg_match_all("#{$functionName} *\( *(['\"])((?:\\\\\\1|.)*?)\\1#", $content, $matches);

        $matches = $matches[2] ?? [];

        return array_reduce($matches, function (array $keys, string $match) {
            $key = str_replace(["\\'", '\\"'], ["'", '"'], $match ?? '');

            return $key ?
                array_merge($keys, [$key => new Translation($key, '')]) :
                $keys;
        }, []);
    }
}
