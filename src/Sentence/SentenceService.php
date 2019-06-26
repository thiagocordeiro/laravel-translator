<?php declare(strict_types=1);

namespace Translator\Sentence;

class SentenceService
{
    /** @var Scanner */
    private $scanner;

    /** @var SentenceRepository */
    private $repository;

    public function __construct(Scanner $scanner, SentenceRepository $repository)
    {
        $this->scanner = $scanner;
        $this->repository = $repository;
    }

    public function storeNewSentencesFromCollection(SentenceCollection $sentences): void
    {
        foreach ($sentences as $sentence) {
            $this->storeNew($sentence);
        }
    }

    public function storeNew(Sentence $sentence): void
    {
        $this->repository->save($sentence);
    }
}
