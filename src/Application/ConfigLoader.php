<?php declare(strict_types=1);

namespace Translator\Application;

interface ConfigLoader
{
    public function languages(): array;

    public function directories(): array;

    public function output(): string;
}
