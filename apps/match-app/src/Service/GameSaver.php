<?php

namespace App\Service;


use App\Entity\Game;
use App\Entity\GameBuffer;
use App\Entity\Itranslated;
use App\Entity\League;
use App\Entity\Sport;
use App\Entity\Team;
use App\Repository\GameRepository;

class GameSaver
{
    private $sportRecognizer;

    private $teamRecognizer;

    private $leagueRecognizer;

    private $gameRepository;


    public function __construct(
        SportRecognizer $sportRecognizer,
        TeamRecognizer $teamRecognizer,
        LeagueRecognizer $leagueRecognizer,
        GameRepository $gameRepository
    ) {
        $this->sportRecognizer = $sportRecognizer;
        $this->teamRecognizer = $teamRecognizer;
        $this->leagueRecognizer = $leagueRecognizer;
        $this->gameRepository = $gameRepository;
    }


    public function saveGame(GameBuffer $gameBuffer)
    {
        $sport  = $this->sportRecognizer->getRecognizedSportByName($gameBuffer->getSport(), $gameBuffer->getLang());
        $league = $this->leagueRecognizer->getRecognizedLeague($gameBuffer->getLeague(), $sport, $gameBuffer->getLang());
        $team1  = $this->teamRecognizer->getRecognizedTeam($gameBuffer->getTeam1(), $sport, $gameBuffer->getLang());
        $team2  = $this->teamRecognizer->getRecognizedTeam($gameBuffer->getTeam2(), $sport, $gameBuffer->getLang());

        // if we recognize sport and a least one of team
        if ($sport && (($team2 xor $team1) ? $league : $team2)) {
            $date1 = (new \DateTime($gameBuffer->getDate()->format('Y-m-d H:i:s')))->modify('-26 hour');
            $date2 = (new \DateTime($gameBuffer->getDate()->format('Y-m-d H:i:s')))->modify('+26 hour');

            $game = $this->gameRepository->getGamesBetweenDates($sport, $date1, $date2, $league, $team1, $team2);

            return $game;
        }
        else {
            return $this->createGame($gameBuffer, $sport, $league, $team1, $team2);
        }
    }


    private function createGame(
        GameBuffer $gameBuffer,
        Sport $sport = null,
        League $league = null,
        Team $team1 = null,
        Team $team2 = null
    ) {

        if (!$sport) {
            $sport = new Sport();
            $this->gameRepository->persist($sport);
        }

        $this->updateEntity($sport, $gameBuffer->getSport(), $gameBuffer->getLang());

        if (!$league) {
            $league = new League();
            $this->gameRepository->persist($league);
        }

        $this->updateEntity($league, $gameBuffer->getLeague(), $gameBuffer->getLang());

        if (!$team1) {
            $team1 = new Team();
            $this->gameRepository->persist($team1);
        }

        $this->updateEntity($team1, $gameBuffer->getTeam1(), $gameBuffer->getLang());

        if (!$team2) {
            $team1 = new Team();
            $this->gameRepository->persist($team1);
        }

        $this->updateEntity($team2, $gameBuffer->getTeam2(), $gameBuffer->getLang());

        $game = new Game();

        $game->setDate($gameBuffer->getDate());

        $game->setLeague($league);

        return $game;

    }

    private function updateEntity(Itranslated $item, $name, $lang)
    {
        if ($lang == 'en') {
            if (!$item->getNameEn()) $item->setNameEn($name);
        }
        else {
            if (!$item->getNameRu()) $item->setNameRu($name);
        }
    }

}