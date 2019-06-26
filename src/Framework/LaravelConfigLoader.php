<?php declare(strict_types=1);

namespace Translator\Framework;

use Translator\Application\ConfigLoader;

class LaravelConfigLoader implements ConfigLoader
{
    /**
     * @return string|string[]
     */
    public function load(string $key, ?string $default = null)
    {
        return config($key, $default);
    }
}
