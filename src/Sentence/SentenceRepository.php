<?php declare(strict_types=1);

namespace Translator\Sentence;

interface SentenceRepository
{
    public function exists(Sentence $sentence, string $language): bool;

    public function save(Sentence $sentence, bool $force = false): void;
}
