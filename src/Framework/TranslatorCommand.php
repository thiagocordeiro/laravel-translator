<?php declare(strict_types=1);

namespace Translator\Framework;

use Illuminate\Console\Command;
use Translator\Translator\TranslationService;

/**
 * @codeCoverageIgnore
 */
class TranslatorCommand extends Command
{
    /** @var string */
    protected $signature = 'translator:update';

    /** @var string */
    protected $description = 'Search new keys and update translation file';

    /** @var TranslationService */
    private $service;

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
