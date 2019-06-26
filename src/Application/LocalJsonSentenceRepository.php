<?php declare(strict_types=1);

namespace Translator\Application;

use Translator\Sentence\Sentence;
use Translator\Sentence\SentenceRepository;

class LocalJsonSentenceRepository implements SentenceRepository
{
    /** @var ConfigLoader */
    private $config;

    public function __construct(ConfigLoader $config)
    {
        $this->config = $config;
    }

    public function exists(Sentence $sentence, string $language): bool
    {
    }

    public function save(Sentence $sentence, bool $force = false): void
    {
        $languages = $this->config->languages();
        dd($languages);
    }
}
