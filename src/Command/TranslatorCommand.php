<?php declare(strict_types=1);

namespace Translator\Command;

use Illuminate\Console\Command;
use Translator\Config\ConfigLoader;
use Translator\Service\FileHandler;
use Translator\Service\Scanner;

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

    /** @var FileHandler */
    private $fileHandler;

    public function __construct(ConfigLoader $config, Scanner $scanner, FileHandler $fileHandler)
    {
        parent::__construct();

        $this->scanner = $scanner;
        $this->config = $config;
        $this->fileHandler = $fileHandler;
    }

    public function handle(): void
    {
        $keys = $this->scanner->scan();
        $files = $this->getProjectTranslationFiles();

        foreach ($files as $file) {
            $newKeys = $this->fileHandler->handle($keys, $file);
            $this->line("File {$file} processed successfully");

            array_map(function (string $key): void {
                $this->warn("- {$key}");
            }, $newKeys);
        }
    }

    /**
     * @return string[]
     */
    private function getProjectTranslationFiles(): array
    {
        $path = $this->config->load('laravel-translator.translations_output');

        return glob("{$path}/*.json", GLOB_BRACE);
    }
}
