<?php declare(strict_types=1);

namespace Translator\Config;

class ConfigLoader
{
    /**
     * @return string[]
     */
    public function load(string $key, ?string $default = null): array
    {
        return config($key, $default);
    }
}
