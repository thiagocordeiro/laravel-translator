<?php declare(strict_types=1);

namespace Translator\Tests\Unit\Translator;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Translator\Translator\ConfigLoader;
use Translator\Translator\Translation;
use Translator\Translator\TranslationRepository;
use Translator\Translator\TranslationScanner;
use Translator\Translator\TranslationService;

class TranslationServiceTest extends TestCase
{
    private string $fixturesDir;

    /** @var MockObject|ConfigLoader */
    private ConfigLoader $configLoader;

    /** @var MockObject|TranslationRepository */
    private TranslationRepository $repository;

    private TranslationService $service;

    protected function setUp(): void
    {
        $this->fixturesDir = realpath(__DIR__ . '/../../Fixtures');

        $this->configLoader = $this->createMock(ConfigLoader::class);
        $this->configLoader
            ->method('languages')
            ->willReturn(['pt']);

        $scanner = new TranslationScanner();
        $this->repository = $this->createMock(TranslationRepository::class);

        $this->service = new TranslationService($this->configLoader, $scanner, $this->repository);
    }

    public function testShouldScanAndSaveKeys(): void
    {
        $this->configLoader
            ->method('extensions')
            ->willReturn(['php']);
        $this->configLoader
            ->method('directories')
            ->willReturn([$this->fixturesDir . '/App/View']);

        $translations = [
            [new Translation('Welcome, :name', '')],
            [new Translation('Trip to :planet, check-in opens :time', '')],
            [new Translation('Check offers to :planet', '')],
            [new Translation('Translations should also work with double quotes.', '')],
            [new Translation('Shouldn\'t escaped quotes within strings also be correctly added?', '')],
            [new Translation('Same goes for "double quotes".', '')],
            [new Translation('String using (parentheses).', '')],
            [new Translation("Double quoted string using \"double quotes\", and C-style escape sequences.\n\t\\", '')],
        ];

        $this->repository
            ->expects($this->exactly(8))
            ->method('save')
            ->withConsecutive(...$translations);

        $this->service->scanAndSaveNewKeys();
    }

    public function testWhenGivenTranslationAlreadyExistsThenDoNotOverride(): void
    {
        $this->configLoader
            ->method('directories')
            ->willReturn([$this->fixturesDir . '/App/Functions/Lang']);
        $this->configLoader
            ->method('extensions')
            ->willReturn(['php']);

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
