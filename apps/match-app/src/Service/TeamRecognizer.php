<?php

namespace App\Service;


use App\Entity\Sport;
use App\Repository\TeamRepository;

class TeamRecognizer
{
    use RecognizerTrait;

    const treshold = 3;

    private $repository;

    private $transliterator;

    private $levenshtein;

    public function __construct(
        TeamRepository  $repository,
        Transliterator $transliterator,
        Levenshtein $levenshtein
    ) {

        $this->repository = $repository;

        $this->transliterator = $transliterator;

        $this->levenshtein = $levenshtein;
    }


    public function getRecognizedTeam(string $name, Sport $sport, string $lang)
    {
        $name = $this->toLowerCase($name);

        $suggestedTeams = $this->repository->findTeamByName(
            $this->prepareNameForSearch($name, $lang),
            $sport
        );

        if (count($suggestedTeams) == 1) {
            $team = array_shift($suggestedTeams);

            if ($this->levenshtein->getLevensteinDistance($team, $name, $lang) < self::treshold) {
                return $team;
            }
        }

        if (!count($suggestedTeams)) {
            $suggestedTeams = $this->repository->findBy(['sport' => $sport]);
        }

        return $this->levenshtein->findSimilarUsingLevenshtein(
            $suggestedTeams,
            $name,
            $lang,
            self::treshold
        );
    }

}