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

    public function exists(Sentence $sentence): bool
    {
        $languages = $this->config->load('translator.languages');
        dd($languages);
        // TODO: Implement exists() method.
    }

    public function save(Sentence $sentence): void
    {
        // TODO: Implement save() method.
    }
}
