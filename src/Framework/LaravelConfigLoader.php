<?php declare(strict_types=1);

namespace Translator\Framework;

use Translator\Application\ConfigLoader;

class LaravelConfigLoader implements ConfigLoader
{
    public function languages(): array
    {
        return $this->load('languages');
    }

    public function directories(): array
    {
        return $this->load('directories');
    }

    public function output(): string
    {
        return $this->load('output');
    }

    /**
     * @return string|string[]
     */
    private function load(string $key, ?string $default = null)
    {
        return config("translator.{$key}", $default);
    }
}
