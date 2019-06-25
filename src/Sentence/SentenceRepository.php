<?php declare(strict_types=1);

namespace Translator\Sentence;

interface SentenceRepository
{
    public function exists(Sentence $sentence): bool;

    public function save(Sentence $sentence): void;
}
