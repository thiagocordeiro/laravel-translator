<?php

namespace Translator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Translator\Command\ConfigResolver;
use Translator\Command\Translator;

class TranslatorTest extends TestCase
{
    /** @var ConfigResolver */
    private $config;

    /** @var Translator */
    private $translator;

    public function setUp()
    {
        $this->config = $this->createMock(ConfigResolver::class);
        $this->config
            ->expects($this->at(0))
            ->method('get')
            ->with('laravel-translator.views_directories')
            ->willReturn([]);

        $this->config
            ->expects($this->at(1))
            ->method('get')
            ->with('laravel-translator.translations_output')
            ->willReturn(__DIR__.'/tests/var/output');

        $this->translator = new Translator($this->config);
    }

    public function testShouldScanDir()
    {
        $this->translator->handle();
    }
}
