<?php declare(strict_types=1);

if (!function_exists('lang')) {
    /**
     * @param string[] $replace
     * @return string|array|null
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

        if (!is_array($files)) {
            return [];
        }

        $directories = glob(dirname($pattern).'/*', GLOB_ONLYDIR | GLOB_NOSORT);

        if (!is_array($directories)) {
            return $files;
        }

        foreach ($directories as $dir) {
            $dirFiles = glob_recursive($dir.'/'.basename($pattern), $flags);
            $files = array_merge($files, $dirFiles);
        }

        return $files;
    }
}
