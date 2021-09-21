<?php

declare(strict_types=1);

namespace Translator\Tests\Unit\Infra;

use PHPUnit\Framework\TestCase;
use Translator\Infra\Exception\InvalidTranslationFile;
use Translator\Infra\Exception\TranslationFileDoesNotExistForLanguage;
use Translator\Infra\Exception\UnableToSaveTranslationKeyAlreadyExists;
use Translator\Infra\LaravelJsonTranslationRepository;
use Translator\Translator\ConfigLoader;
use Translator\Translator\Translation;

class LaravelJsonTranslationRepositoryTest extends TestCase
{
    private string $translationPath;
    private LaravelJsonTranslationRepository $repository;

    protected function setUp(): void
    {
        $this->translationPath = realpath(__DIR__.'/../../Fixtures/translations');
        $configLoader = $this->createMock(ConfigLoader::class);
        $configLoader
            ->method('output')
            ->willReturn($this->translationPath);

        file_put_contents("{$this->translationPath}/fr.json", '{}');

        $this->repository = new LaravelJsonTranslationRepository($configLoader);
    }

    public function testWhenFileForGivenLanguageDoesNotExistThenThrowException(): void
    {
        $translation = new Translation('', '');
        $language = 'nl';

        $this->expectException(TranslationFileDoesNotExistForLanguage::class);

        $this->repository->exists($translation, $language);
    }

    public function testWhenFileForGivenLanguageDoesNotContainAValidJsonContentThenThrowException(): void
    {
        $translation = new Translation('', '');
        $language = 'de';

        $this->expectException(InvalidTranslationFile::class);

        $this->repository->exists($translation, $language);
    }

    public function testWhenGivenANewKeyThenExistsIsFalse(): void
    {
        $translation = new Translation('You shall not pass', '');
        $language = 'es';

        $exists = $this->repository->exists($translation, $language);

        $this->assertFalse($exists);
    }

    public function testWhenGivenARegisteredKeyThenExistsIsTrue(): void
    {
        $translation = new Translation('You shall not pass', '');
        $language = 'pt';

        $exists = $this->repository->exists($translation, $language);

        $this->assertTrue($exists);
    }

    public function testWhenTryingToSaveAKeyWhichAlreadyExistsThenThrowException(): void
    {
        $translation = new Translation("I'll be back", '');
        $this->repository->save($translation, 'fr');

        $this->expectException(UnableToSaveTranslationKeyAlreadyExists::class);

        $this->repository->save($translation, 'fr');
    }

    public function testSavingATranslationThenUpdateFile(): void
    {
        $translation = new Translation("I'll be back", '');

        $this->repository->save($translation, 'fr');

        $josn = json_decode(file_get_contents("$this->translationPath/fr.json"), true);
        $this->assertEquals(['I\'ll be back' => 'I\'ll be back'], $josn);
    }

    public function testWhenTryingToLoadAnInvalidJsonFileThenThrowException(): void
    {
        $translation = new Translation("I'll be back", '');

        $this->expectException(InvalidTranslationFile::class);

        $this->repository->save($translation, 'ru');
    }
}
