<?php declare(strict_types=1);

namespace Tests\Unit\Translator\Translator;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Translator\Translator\ConfigLoader;
use Translator\Translator\Translation;
use Translator\Translator\TranslationRepository;
use Translator\Translator\TranslationScanner;
use Translator\Translator\TranslationService;

class TranslationServiceTest extends TestCase
{
    /** @var string */
    private $fixturesDir;

    /** @var MockObject|ConfigLoader */
    private $configLoader;

    /** @var MockObject|TranslationScanner */
    private $scanner;

    /** @var MockObject|TranslationRepository */
    private $repository;

    /** @var TranslationService */
    private $service;

    protected function setUp(): void
    {
        $this->fixturesDir = realpath(__DIR__.'/../../Fixtures');

        $this->configLoader = $this->createMock(ConfigLoader::class);
        $this->configLoader
            ->method('languages')
            ->willReturn(['pt']);

        $this->scanner = new TranslationScanner();
        $this->repository = $this->createMock(TranslationRepository::class);

        $this->service = new TranslationService($this->configLoader, $this->scanner, $this->repository);
    }

    public function testShouldScanAndSaveKeys(): void
    {
        $this->configLoader
            ->method('directories')
            ->willReturn([$this->fixturesDir.'/App/View']);

        $translations = [
            [new Translation('Welcome, :name', '')],
            [new Translation('Trip to :planet, check-in opens :time', '')],
            [new Translation('Check offers to :planet', '')],
            [new Translation('Translations should also work with double quotes.', '')],
            [new Translation('Shouldn\'t escaped quotes within strings also be correctly added?', '')],
            [new Translation('Same goes for "double quotes".', '')],
            [new Translation('String using (parentheses).', '')],
        ];

        $this->repository
            ->expects($this->exactly(7))
            ->method('save')
            ->withConsecutive(...$translations);

        $this->service->scanAndSaveNewKeys();
    }

    public function testWhenGivenTranslationAlreadyExistsThenDoNotOverride(): void
    {
        $this->configLoader
            ->method('directories')
            ->willReturn([$this->fixturesDir.'/App/Functions/Lang']);

        $this->repository
            ->method('exists')
            ->with(new Translation('Lang: :foo, :bar', ''))
            ->willReturn(true);

        $this->repository
            ->expects($this->never())
            ->method('save');

        $this->service->scanAndSaveNewKeys();
    }
}
