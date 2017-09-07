<?php

if (!function_exists('lang')) {
    /**
     * Translate the given message.
     *
     * @param  string $key
     * @param  array $replace
     * @param  string $locale
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    function lang($key = null, $replace = [], $locale = null)
    {
        return __($key, $replace, $locale);
    }
}

if (!function_exists('glob_recursive')) {
    /**
     * Find pathnames matching a pattern recursively
     *
     * @param $pattern
     * @param int $flags
     * @return array
     */
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }
}
