<?php declare(strict_types=1);

namespace Translator\Sentence;

class SentenceService
{
    /** @var SentenceRepository */
    private $repository;

    public function __construct(SentenceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function storeNewSentencesFromCollection(SentenceCollection $sentences)
    {
        foreach ($sentences as $sentence) {
            $this->storeNew($sentence);
        }
    }

    public function storeNew(Sentence $sentence)
    {
        if ($this->repository->exists($sentence)) {
            return;
        }

        $this->repository->save($sentence);
    }
}
