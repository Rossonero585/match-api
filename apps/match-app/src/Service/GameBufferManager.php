<?php

namespace App\Service;

use App\Entity\GameBuffer;
use App\Model\GameBufferRequest;
use App\Repository\GameBufferRepository;

class GameBufferManager
{

    private $bufferRepository;

    private $recognizer;

    public function __construct(GameBufferRepository $bufferRepository, LanguageRecognizer $recognizer)
    {
        $this->bufferRepository = $bufferRepository;

        $this->recognizer = $recognizer;
    }

    public function createFromGameBufferRequest(GameBufferRequest $request) : GameBuffer
    {
        $gameBuffer = new GameBuffer();

        $gameBuffer->setSport($request->getSport());
        $gameBuffer->setLeague($request->getLeague());
        $gameBuffer->setTeam1($request->getTeam1());
        $gameBuffer->setTeam2($request->getTeam2());
        $gameBuffer->setSource($request->getSource());

        $gameBuffer->setDate(\DateTime::createFromFormat('Y-m-d H:i:s', $request->getDate()));

        $gameBuffer->setLang($this->recognizer->recognizeLanguage($request->getLang()));

        $this->bufferRepository->persist($gameBuffer);
        $this->bufferRepository->flush();

        return $gameBuffer;
    }
}