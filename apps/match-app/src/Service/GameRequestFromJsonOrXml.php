<?php

namespace App\Service;


use App\Model\GameBufferRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GameRequestFromJsonOrXml implements IGameRequestBuilder
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var SerializerInterface
     */
    private $serializer;


    public function __construct(RequestStack $requestStack, SerializerInterface $serializer)
    {
        $this->request = $requestStack->getCurrentRequest();

        $this->serializer = $serializer;
    }

    public function getGameRequest() : GameBufferRequest
    {
        /** @var GameBufferRequest $game */
        $game = $this->serializer->deserialize(
            $this->request->getContent(),
            GameBufferRequest::class,
            $this->request->getContentType() == 'json' ?: 'xml'
        );

        $game->setSource($this->request->getHost());

        return $game;
    }

}