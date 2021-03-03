<?php declare(strict_types=1);

namespace Translator\Framework;

use Translator\Translator\ConfigLoader;

/**
 * @codeCoverageIgnore
 */
class LaravelConfigLoader implements ConfigLoader
{
    /**
     * @inheritDoc
     */
    public function languages(): array
    {
        return $this->loadConfigInArray('languages');
    }

    /**
     * @inheritDoc
     */
    public function directories(): array
    {
        return $this->loadConfigInArray('directories');
    }

    /**
     * @inheritDoc
     */
    public function output(): string
    {
        return $this->loadConfigInString('output');
    }

    /**
     * @inheritDoc
     */
    public function extensions(): array
    {
        return $this->loadConfigInArray('extensions');
    }

    /**
     * @return array<string>
     */
    private function loadConfigInArray(string $key): array
    {
        $values = $this->load($key);

        if (!is_array($values)) {
            return [];
        }

        return $values;
    }

    public function loadConfigInString(string $key): string
    {
        $value = $this->load($key);

        if (!is_string($value)) {
            return '';
        }

        return $value;
    }

    /**
     * @return string|string[]
     */
    private function load(string $key)
    {
        return config("translator.{$key}");
    }
}
