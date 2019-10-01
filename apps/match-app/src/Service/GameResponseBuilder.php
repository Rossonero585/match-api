<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\GameBuffer;
use App\Entity\Itranslated;
use App\Model\GameResponse;
use Symfony\Component\Serializer\SerializerInterface;

class GameResponseBuilder
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getGameResponse(Game $game) : GameResponse
    {
        $lang = $this->getFavoriteLang($game);

        return new GameResponse(
            $this->getName($game->getSport(), $lang),
            $this->getName($game->getLeague(), $lang),
            $this->getName($game->getTeam1(), $lang),
            $this->getName($game->getTeam2(), $lang),
            $game->getDate()->format('Y-m-d H:i:s'),
            count($game->getGameBuffers())
        );
    }

    public function serializeResponse(GameResponse $response, $format = 'json') : string
    {
        return $this->serializer->serialize($response, $format);
    }

    private function getName(Itranslated $item, $lang)
    {
        return $lang == 'en' ? $item->getNameEn() : $item->getNameRu();
    }

    private function getFavoriteLang(Game $game)
    {
        $bufferGames = $game->getGameBuffers()->toArray();

        /** @var GameBuffer $bufferedGame */
        $bufferedGame = array_shift($bufferGames);

        return $bufferedGame->getLang();
    }
}