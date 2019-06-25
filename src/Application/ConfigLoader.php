<?php declare(strict_types=1);

namespace Translator\Application;

class ConfigLoader
{
    /**
     * @return string|string[]
     */
    public function load(string $key, ?string $default = null)
    {
        return config($key, $default);
    }
}
