<?php declare(strict_types=1);

namespace Translator\Framework;

use Illuminate\Console\Command;
use Translator\Translator\TranslationService;

/**
 * @codeCoverageIgnore
 */
class TranslatorCommand extends Command
{
    /** @inheritdoc */
    protected $signature = 'translator:update';

    /** @inheritdoc */
    protected $description = 'Search new keys and update translation file';

    private TranslationService $service;

    public function __construct(TranslationService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function handle(): void
    {
        $this->service->scanAndSaveNewKeys();
    }
}
