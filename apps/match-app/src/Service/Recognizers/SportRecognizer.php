<?php

namespace App\Service\Recognizers;

use App\Repository\SportRepository;

class SportRecognizer
{
    use RecognizerTrait;

    private $repository;

    private $transliterator;

    private $levenshtein;

    private $threshold;

    public function __construct(
        SportRepository $repository,
        Transliterator $transliterator,
        Levenshtein $levenshtein,
        int $threshold
    ) {
        $this->repository = $repository;

        $this->transliterator = $transliterator;

        $this->levenshtein = $levenshtein;

        $this->threshold = $threshold;
    }

    public function getRecognizedSportByName(string $name, string $lang)
    {
        $suggestedSports = $this->repository->findSportByName($this->prepareNameForSearch($name, $lang));

        if (count($suggestedSports) == 1) return array_shift($suggestedSports);

        if (!count($suggestedSports)) {
            $suggestedSports = $this->repository->findAll();
        }

        return $this->levenshtein->findSimilarUsingLevenshtein(
            $suggestedSports,
            $name,
            $lang,
            $this->threshold
        );
    }
}