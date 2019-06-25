<?php declare(strict_types=1);

namespace Translator\Framework;

use Exception;
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

    /** @var ConfigLoader */
    private $config;

    /** @var Scanner */
    private $scanner;

    /** @var SentenceService */
    private $service;

    public function __construct(ConfigLoader $config, Scanner $scanner, SentenceService $service)
    {
        parent::__construct();

        $this->scanner = $scanner;
        $this->config = $config;
        $this->service = $service;
    }

    public function handle(): void
    {
        $directories = $this->config->load('laravel-translator.directories');
//        $outputDirectory = $this->config->load('laravel-translator.translations_output');
//        $outputFiles = $this->getProjectTranslationFiles($outputDirectory);

        $sentences = $this->scanner->scan(...$directories);

//        foreach ($outputFiles as $file) {
        $this->service->storeNewSentencesFromCollection($sentences);
//        }

//        dd($sentences);

//        $files = $this->getProjectTranslationFiles();
//
//        $this->line('');
//
//        foreach ($files as $file) {
//            $newKeys = $this->fileHandler->handle($sentences, $file);
//            $lang = basename($file);
//            $updated = count($newKeys) > 0;
//            $this->info("Language {$lang} processed successfully ".($updated ? 'with' : 'without')." updates");
//
//            array_map(function (string $key): void {
//                $this->warn("- {$key}");
//            }, $newKeys);
//
//            $this->line('');
//        }
    }

    /**
     * @return string[]
     */
    private function getProjectTranslationFiles(string $path): array
    {
        $files = glob("{$path}/*.json", GLOB_BRACE);

        if (!$files) {
            throw new Exception('Unable to load translation files');
        }

        return $files;
    }
}
