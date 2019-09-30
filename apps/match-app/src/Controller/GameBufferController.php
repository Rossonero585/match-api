<?php

namespace App\Controller;


use App\Service\GeneralManager;
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
    public function postGame(IGameRequestBuilder $gameRequestBuilder, ValidatorInterface $validator, GeneralManager $generalManager)
    {
        $gameRequest = $gameRequestBuilder->getGameRequest();

        $errors = $validator->validate($gameRequest);

        if ($errors->count()) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $game = $generalManager->saveGame($gameRequest);

        return new Response($game->getId(), Response::HTTP_OK);
    }
}
