<?php declare(strict_types=1);

namespace Translator\Config;

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
