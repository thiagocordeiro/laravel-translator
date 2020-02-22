<?php declare(strict_types=1);

namespace Tests\Unit\Translator\Translator;

use PHPUnit\Framework\TestCase;
use Translator\Translator\Exception\InvalidDirectoriesConfiguration;
use Translator\Translator\Translation;
use Translator\Translator\TranslationScanner;

class TranslationScannerTest extends TestCase
{
    /** @var string */
    private $fixturesDir;

    /** @var TranslationScanner */
    private $scanner;

    protected function setUp(): void
    {
        $this->fixturesDir = realpath(__DIR__.'/../../Fixtures');
        $this->scanner = new TranslationScanner();
    }

    public function testWhenDirectoriesToScanAreNotSetThenThrowException(): void
    {
        $directories = [];

        $this->expectException(InvalidDirectoriesConfiguration::class);

        $this->scanner->scan(...$directories);
    }

    public function testShouldFindTranslationsForUnderscoreFunctions(): void
    {
        $__dir = $this->fixturesDir.'/App/Functions/UnderscoreUnderscore';

        $translations = $this->scanner->scan(...[$__dir]);

        $this->assertEquals(
            [
                'Underscore: :foo, :bar' => new Translation('Underscore: :foo, :bar', ''),
            ],
            $translations
        );
    }

    public function testShouldFindTranslationsForLangFunctions(): void
    {
        $langDir = $this->fixturesDir.'/App/Functions/Lang';

        $translations = $this->scanner->scan(...[$langDir]);

        $this->assertEquals(
            [
                'Lang: :foo, :bar' => new Translation('Lang: :foo, :bar', ''),
            ],
            $translations
        );
    }

    public function testShouldFindTranslationsForBladeTemplates(): void
    {
        $viewDir = $this->fixturesDir.'/App/View';

        $translations = $this->scanner->scan(...[$viewDir]);

        $this->assertEquals(
            [
                'Welcome, :name' => new Translation('Welcome, :name', ''),
                'Trip to :planet, check-in opens :time' => new Translation('Trip to :planet, check-in opens :time', ''),
                'Check offers to :planet' => new Translation('Check offers to :planet', ''),
                'Translations should also work with double quotes.' => new Translation(
                    'Translations should also work with double quotes.',
                    ''
                ),
                'Shouldn\'t escaped quotes within strings also be correctly added?' => new Translation(
                    'Shouldn\'t escaped quotes within strings also be correctly added?',
                    ''
                ),
                'Same goes for "double quotes".' => new Translation('Same goes for "double quotes".', ''),
                'String using (parentheses).' => new Translation('String using (parentheses).', ''),
            ],
            $translations
        );
    }

    public function testShouldFindMultipleTranslationForDifferentFunctionsAndFiles(): void
    {
        $appDir = $this->fixturesDir.'/App';

        $translations = $this->scanner->scan(...[$appDir]);

        $this->assertEquals(
            [
                'Welcome, :name' => new Translation('Welcome, :name', ''),
                'Trip to :planet, check-in opens :time' => new Translation('Trip to :planet, check-in opens :time', ''),
                'Check offers to :planet' => new Translation('Check offers to :planet', ''),
                'Translations should also work with double quotes.' => new Translation(
                    'Translations should also work with double quotes.',
                    ''
                ),
                'Shouldn\'t escaped quotes within strings also be correctly added?' => new Translation(
                    'Shouldn\'t escaped quotes within strings also be correctly added?',
                    ''
                ),
                'Same goes for "double quotes".' => new Translation('Same goes for "double quotes".', ''),
                'String using (parentheses).' => new Translation('String using (parentheses).', ''),
                'Underscore: :foo, :bar' => new Translation('Underscore: :foo, :bar', ''),
                'Lang: :foo, :bar' => new Translation('Lang: :foo, :bar', ''),
            ],
            $translations
        );
    }
}
