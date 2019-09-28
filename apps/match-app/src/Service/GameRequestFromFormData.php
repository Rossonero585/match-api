<?php

namespace App\Service;


use App\Model\GameBufferRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class GameRequestFromFormData implements IGameRequestBuilder
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    function getGameRequest() : GameBufferRequest
    {
        return new GameBufferRequest(
            $this->request->get('date'),
            $this->request->get('sport'),
            $this->request->get('league'),
            $this->request->get('team1'),
            $this->request->get('team2'),
            $this->request->getHttpHost()
        );
    }

}