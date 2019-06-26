<?php declare(strict_types=1);

namespace Translator\Application;

use Translator\Sentence\Sentence;
use Translator\Sentence\SentenceRepository;

class LocalJsonSentenceRepository implements SentenceRepository
{
    public function exists(Sentence $sentence): bool
    {
        // TODO: Implement exists() method.
    }

    public function save(Sentence $sentence): void
    {
        // TODO: Implement save() method.
    }
}
