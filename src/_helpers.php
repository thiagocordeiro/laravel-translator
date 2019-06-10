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
    function glob_recursive(string $pattern, int $flags = 0): array
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }

        return $files;
    }
}
