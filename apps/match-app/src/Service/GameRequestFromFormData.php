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
            $this->request->get('source'),
            $this->request->get('lang')
        );
    }

    public function getGameRequests() : array
    {
        $requests = [];

        foreach ($this->request->get('date') as $key => $date) {
            array_push($requests, new GameBufferRequest(
                $this->request->get('date')[$key],
                $this->request->get('sport')[$key],
                $this->request->get('league')[$key],
                $this->request->get('team1')[$key],
                $this->request->get('team2')[$key],
                $this->request->get('source')[$key],
                $this->request->get('lang')[$key]
            ));
        }

        return $requests;
    }

}