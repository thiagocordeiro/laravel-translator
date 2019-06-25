<?php declare(strict_types=1);

namespace Translator\Sentence;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class SentenceCollection implements IteratorAggregate, Countable
{
    /** @var Sentence[] */
    private $sentences;

    public function __construct(Sentence ...$sentences)
    {
        $this->sentences = $sentences;
    }

    /**
     * @return Sentence[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->sentences);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->sentences);
    }

    public function push(Sentence ...$sentences)
    {
        $this->sentences = array_merge($this->sentences, $sentences);
    }
}
