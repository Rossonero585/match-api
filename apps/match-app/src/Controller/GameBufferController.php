<?php

namespace App\Controller;


use App\Repository\GameRepository;
use App\Service\GameResponseBuilder;
use App\Model\GameBufferRequest;
use App\Service\GeneralManager;
use App\Service\IGameRequestBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/game_package", name="game_buffer_package")
     */
    public function postGamePackage(IGameRequestBuilder $gameRequestBuilder, ValidatorInterface $validator, GeneralManager $generalManager)
    {
        $errors = [];

        /** @var GameBufferRequest $gameRequest */
        foreach ($gameRequestBuilder->getGameRequests() as $key => $gameRequest) {

            $error = $validator->validate($gameRequest);

            if ($error->count() > 0) $errors[$key] = $error;

            if (!$errors) {
                $generalManager->saveGame($gameRequest);
            }
        }

        if (count($errors)) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        return new Response("", Response::HTTP_OK);
    }


    /**
     * @Route("/random_match", name="random_match")
     */

    public function getRandomMatch(Request $request, GameRepository $repository, GameResponseBuilder $builder)
    {
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $source = $request->get('source');

        $game = $repository->getRandomGame(
            $date1 ? $this->createDateTimeFromString($date1) : null,
            $date2 ? $this->createDateTimeFromString($date2) : null,
            $source
        );

        if (!$game) {
            return new Response('Game is not found', Response::HTTP_NOT_FOUND);
        }

        $gameResponse = $builder->getGameResponse($game);

        return new JsonResponse(
            $builder->serializeResponse($gameResponse),
            Response::HTTP_OK,
            [],
            true
        );
    }

    private function createDateTimeFromString(string $date)
    {
       return \DateTime::createFromFormat('Y-m-d H:i:s', $date);
    }
}
