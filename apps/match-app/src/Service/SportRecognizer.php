<?php

namespace App\Service;

use App\Repository\SportRepository;

class SportRecognizer
{
    use RecognizerTrait;

    private $repository;

    private $transliterator;

    private $levenshtein;

    public function __construct(
        SportRepository $repository,
        Transliterator $transliterator,
        Levenshtein $levenshtein
    ) {
        $this->repository = $repository;

        $this->transliterator = $transliterator;

        $this->levenshtein = $levenshtein;
    }

    public function getRecognizedSportByName(string $name, string $lang)
    {
        $name = $this->toLowerCase($name);

        $suggestedSports = $this->repository->findSportByName($this->prepareNameForSearch($name, $lang));

        if (count($suggestedSports) == 1) return array_shift($suggestedSports);

        if (!count($suggestedSports)) {
            $suggestedSports = $this->repository->findAll();
        }

        return $this->levenshtein->findSimilarUsingLevenshtein(
            $suggestedSports,
            $name,
            $lang,
            3
        );
    }
}