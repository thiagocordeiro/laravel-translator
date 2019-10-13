<?php declare(strict_types=1);

namespace Translator\Translator;

interface TranslationRepository
{
    public function exists(Translation $translation, string $language): bool;

    public function save(Translation $translation, string $language): void;
}
