<?php

namespace App\Controller;


use App\Service\GameSaver;
use App\Service\IGameRequestBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;


class GameBufferController extends AbstractController
{
    /**
     * @Route("/game", name="game_buffer")
     */
    public function postGame(IGameRequestBuilder $gameRequestBuilder, ValidatorInterface $validator, GameSaver $gameSaver)
    {
        $gameRequest = $gameRequestBuilder->getGameRequest();

        $errors = $validator->validate($gameRequest);

        if ($errors->count()) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $game = $gameSaver->createFromGameBufferRequest($gameRequest);

        return new Response($game->getId());
    }
}
