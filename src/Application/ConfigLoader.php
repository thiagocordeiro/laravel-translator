<?php declare(strict_types=1);

namespace Translator\Application;

interface ConfigLoader
{
    /**
     * @return string|string[]
     */
    public function load(string $key, ?string $default = null);
}
