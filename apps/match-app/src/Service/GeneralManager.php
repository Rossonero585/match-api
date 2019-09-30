<?php

namespace App\Service;

use App\Model\GameBufferRequest;

class GeneralManager
{

    /**
     * @var GameBufferManager
     */
    private $gameBufferManager;

    /**
     * @var GameManager
     */
    private $gameManager;


    public function __construct(GameBufferManager $gameBufferManager, GameManager $gameManager)
    {
        $this->gameBufferManager = $gameBufferManager;

        $this->gameManager = $gameManager;
    }


    /**
     * @param GameBufferRequest $request
     * @return Game|mixed
     */
    public function saveGame(GameBufferRequest $request)
    {
        $bufferedGame = $this->gameBufferManager->createFromGameBufferRequest($request);

        return $this->gameManager->saveGame($bufferedGame);
    }
}