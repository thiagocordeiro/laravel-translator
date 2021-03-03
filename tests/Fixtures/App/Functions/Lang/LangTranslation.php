<?php declare(strict_types=1);

namespace Translator\Tests\Fixtures\App\Functions\Lang;

class LangTranslation
{
    private string $foo;
    private string $bar;

    public function __construct(string $foo, string $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    public function getFoo(): string
    {
        return $this->foo;
    }

    public function getBar(): string
    {
        return $this->bar;
    }

    public function __toString(): string
    {
        return __("Lang: :foo, :bar", [':foo' => $this->foo, ':bar' => $this->bar]);
    }
}
