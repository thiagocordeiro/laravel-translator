<?php declare(strict_types=1);

namespace Translator\Framework;

use Illuminate\Console\Command;
use Translator\Application\ConfigLoader;
use Translator\Sentence\Scanner;
use Translator\Sentence\SentenceService;

class TranslatorCommand extends Command
{
    /** @var string */
    protected $signature = 'translator:update';

    /** @var string */
    protected $description = 'Search new keys and update translation file';

    /** @var LaravelConfigLoader */
    private $config;

    /** @var Scanner */
    private $scanner;

    /** @var SentenceService */
    private $service;

    public function __construct(ConfigLoader $config, Scanner $scanner, SentenceService $service)
    {
        parent::__construct();

        $this->config = $config;
        $this->scanner = $scanner;
        $this->service = $service;
    }

    public function handle(): void
    {
        $directories = $this->config->directories();

        $sentences = $this->scanner->scan(...$directories);

        $this->service->storeNewSentencesFromCollection($sentences);
    }
}
