<?php

namespace App\Service;


use App\Entity\Game;
use App\Entity\GameBuffer;
use App\Entity\Itranslated;
use App\Entity\League;
use App\Entity\Sport;
use App\Entity\Team;
use App\Repository\GameRepository;

class GameManager
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

        if (!$sport) {
            $game = $this->createGame($gameBuffer);
        }
        else {
            $league = $this->leagueRecognizer->getRecognizedLeague($gameBuffer->getLeague(), $sport, $gameBuffer->getLang());
            $team1  = $this->teamRecognizer->getRecognizedTeam($gameBuffer->getTeam1(), $sport, $gameBuffer->getLang());
            $team2  = $this->teamRecognizer->getRecognizedTeam($gameBuffer->getTeam2(), $sport, $gameBuffer->getLang());

            // if we recognize sport and at least one of team
            if ($sport && ($team1 || $team2)) {
                $date1 = (new \DateTime($gameBuffer->getDate()->format('Y-m-d H:i:s')))->modify('-26 hour');
                $date2 = (new \DateTime($gameBuffer->getDate()->format('Y-m-d H:i:s')))->modify('+26 hour');

                $game = $this->gameRepository->getGamesBetweenDates($sport, $date1, $date2, $league, $team1, $team2);

                if ($game) $this->updateGame($game, $gameBuffer);
            }

            if (!isset($game)) {
                $game = $this->createGame($gameBuffer, $sport, $league, $team1, $team2);
            }
        }

        $gameBuffer->setGame($game);

        $this->gameRepository->flush();

        return $game;
    }


    private function createGame(
        GameBuffer $gameBuffer,
        Sport $sport = null,
        League $league = null,
        Team $team1 = null,
        Team $team2 = null
    ) {

        $game = new Game();

        $sport = $sport ?: new Sport();

        $league = $league ?: new League();

        $team1 = $team1 ?: new Team();

        $team2 = $team2 ?: new Team();

        $league->setSport($sport);

        $team1->setSport($sport);

        $team2->setSport($sport);

        $game->setDate($gameBuffer->getDate())
            ->setSport($sport)
            ->setLeague($league)
            ->setTeam1($team1)
            ->setTeam2($team2);

        $this->updateGame($game, $gameBuffer);

        $this->gameRepository->persist($game);

        return $game;

    }

    private function updateEntityNames(Itranslated $item, $name, $lang)
    {
        if ($lang == 'en') {
            if (!$item->getNameEn()) $item->setNameEn($name);
        }
        else {
            if (!$item->getNameRu()) $item->setNameRu($name);
        }
    }

    private function updateGame(Game $game, GameBuffer $gameBuffer)
    {
        $game->addGameBuffer($gameBuffer);

        if (count($game->getGameBuffers()) > 1) {
            $game->setDate($this->getApproximateGameDate($game->getGameBuffers()));
        }

        $this->updateEntityNames($game->getSport(), $gameBuffer->getSport(), $gameBuffer->getLang());
        $this->updateEntityNames($game->getLeague(), $gameBuffer->getLeague(), $gameBuffer->getLang());
        $this->updateEntityNames($game->getTeam1(), $gameBuffer->getTeam1(), $gameBuffer->getLang());
        $this->updateEntityNames($game->getTeam2(), $gameBuffer->getTeam2(), $gameBuffer->getLang());
    }

    private function getApproximateGameDate(\ArrayAccess $collection)
    {
        $dates = [];

        /** @var GameBuffer $gameBuffer */
        foreach ($collection as $gameBuffer) {

            $key = $gameBuffer->getDate()->getTimestamp();

            if (isset($dates[$key])) {
                $dates[$key] = ++$dates[$key];
            }
            else {
                $dates[$key] = 1;
            }
        }

        $approximateTimestamp = array_keys($dates, max($dates))[0];

        return \DateTime::createFromFormat('U', $approximateTimestamp);
    }

}