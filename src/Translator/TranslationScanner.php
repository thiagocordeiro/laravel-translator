<?php declare(strict_types=1);

namespace Translator\Translator;

use Translator\Translator\Exception\InvalidDirectoriesConfiguration;
use Translator\Translator\Exception\InvalidExtensionsConfiguration;
use Translator\Translator\Exception\InvalidFunctionsConfiguration;

class TranslationScanner
{
    /**
     * @param string[] $extensions
     * @param string[] $directories
     * @param string[] $functions
     * @return Translation[]
     * @throws InvalidDirectoriesConfiguration
     * @throws InvalidExtensionsConfiguration
     * @throws InvalidFunctionsConfiguration
     */
    public function scan(array $extensions, array $directories, array $functions): array
    {
        if (empty($extensions)) {
            throw new InvalidExtensionsConfiguration();
        }

        if (empty($directories)) {
            throw new InvalidDirectoriesConfiguration();
        }

        if (empty($functions)) {
            throw new InvalidFunctionsConfiguration();
        }

        $ext = implode(',', $extensions);

        return array_reduce(
            $directories,
            function (array $collection, string $directory) use ($ext, $functions): array {
                return array_merge(
                    $collection,
                    $this->scanDirectory($directory, $ext, $functions)
                );
            },
            []
        );
    }

    /**
     * @param string[] $functions
     * @return Translation[]
     */
    private function scanDirectory(string $path, string $extensions, array $functions): array
    {
        $files = glob_recursive("{$path}/*.{{$extensions}}", GLOB_BRACE);

        return array_reduce($files, function (array $keys, $file) use ($functions): array {
            $content = $this->getFileContent($file);

            $keysFromFunctions = array_reduce(
                $functions,
                function (array $keys, string $function) use ($content): array {
                    return array_merge($keys, $this->getKeysFromFunction($function, $content));
                },
                []
            );

            return array_merge(
                $keys,
                $keysFromFunctions
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
        preg_match_all("#{$functionName} *\( *((['\"])((?:\\\\\\2|.)*?)\\2)#", $content, $matches);

        $matches = $matches[1] ?? [];

        return array_reduce($matches, function (array $keys, string $match) {
            $quote = $match[0];
            $match = trim($match, $quote);
            $key = ($quote === '"') ? stripcslashes($match) : str_replace(["\\'", "\\\\"], ["'", "\\"], $match);

            return $key ?
                array_merge($keys, [$key => new Translation($key, '')]) :
                $keys;
        }, []);
    }
}
