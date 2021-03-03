<?php declare(strict_types=1);

if (!function_exists('lang')) {
    /**
     * @codeCoverageIgnore
     * @param string[] $replace
     * @return string|array<string|int|float>|null
     */
    function lang(string $key, array $replace = [], ?string $locale = null)
    {
        return __($key, $replace, $locale);
    }
}

if (!function_exists('glob_recursive')) {
    /**
     * @return string[]
     */
    function glob_recursive(string $pattern, int $flags = 0): array
    {
        $files = glob($pattern, $flags);

        if (!$files) {
            $files = [];
        }

        $directories = glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) ?? [];

        if (!$directories) {
            $directories = [];
        }

        return array_reduce($directories, function (array $files, string $dir) use ($pattern, $flags): array {
            return array_merge(
                $files,
                glob_recursive($dir . '/' . basename($pattern), $flags)
            );
        }, $files);
    }
}
