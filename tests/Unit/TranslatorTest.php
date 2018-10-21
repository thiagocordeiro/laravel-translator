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
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                [__DIR__.'/../Fixtures/Class', __DIR__.'/../Fixtures/View'],
                __DIR__.'/../Fixtures/Output'
            );

        $this->translator = new Translator($this->config);
    }

    public function testShouldScanDir()
    {
        $this->translator->handle();
    }
}
