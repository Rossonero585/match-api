<?php

namespace App\Service;

use App\Entity\Sport;
use App\Repository\LeagueRepository;

class LeagueRecognizer
{
    use RecognizerTrait;

    private $threshold;

    private $repository;

    private $transliterator;

    private $levenshtein;

    public function __construct(
        LeagueRepository $repository,
        Transliterator $transliterator,
        Levenshtein $levenshtein,
        int $threshold
    ) {
        $this->repository = $repository;

        $this->transliterator = $transliterator;

        $this->levenshtein = $levenshtein;

        $this->threshold = $threshold;
    }


    public function getRecognizedLeague(string $name, Sport $sport, string $lang)
    {
        $name = $this->toLowerCase($name);

        $suggestedLeagues = $this->repository->findLeagueByName(
            $this->prepareNameForSearch($name, $lang),
            $sport
        );

        if (count($suggestedLeagues) == 1) {

            $league = array_shift($suggestedLeagues);

            if ($this->levenshtein->getLevensteinDistance($league, $name, $lang) <= $this->threshold) {
                return $league;
            }
        }

        if (!count($suggestedLeagues)) {
            $suggestedLeagues = $this->repository->findBy(['sport' => $sport]);
        }

        return $this->levenshtein->findSimilarUsingLevenshtein(
            $suggestedLeagues,
            $name,
            $lang,
            $this->threshold
        );
    }
}