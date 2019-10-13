<?php declare(strict_types=1);

namespace Tests\Fixtures\App\Functions\Lang;

class LangTranslation
{
    /** @var string */
    private $foo;

    /** @var string */
    private $bar;

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
