<?php declare(strict_types=1);

namespace Translator\Translator;

interface ConfigLoader
{
    public function languages(): array;

    public function directories(): array;

    public function output(): string;

    public function scannableFiles(): string;

}
