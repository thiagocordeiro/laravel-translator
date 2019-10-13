<?php declare(strict_types=1);

namespace Tests\Fixtures\App\Functions\UnderscoreUnderscore;

class UnderscoreUnderscoreTranslation
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
        return __("Underscore: :foo, :bar", [':foo' => $this->foo, ':bar' => $this->bar]);
    }
}
