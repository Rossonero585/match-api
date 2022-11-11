<?php

namespace App\Service\Recognizers;


use App\Entity\Sport;
use App\Repository\TeamRepository;

class TeamRecognizer
{
    use RecognizerTrait;

    private $repository;

    private $transliterator;

    private $levenshtein;

    private $threshold;

    public function __construct(
        TeamRepository  $repository,
        Transliterator $transliterator,
        Levenshtein $levenshtein,
        int $threshold
    ) {

        $this->repository = $repository;

        $this->transliterator = $transliterator;

        $this->levenshtein = $levenshtein;

        $this->threshold = $threshold;
    }


    public function getRecognizedTeam(string $name, Sport $sport, string $lang)
    {
        $suggestedTeams = $this->repository->findTeamByName(
            $this->prepareNameForSearch($name, $lang),
            $sport
        );
        
        $count = count($suggestedTeams);

        if ($count == 1) {
            $team = array_shift($suggestedTeams);

            if ($this->levenshtein->getLevensteinDistance($team, $name, $lang) <= $this->threshold) {
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
            $this->threshold
        );
    }

}