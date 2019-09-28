<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class GameBuilderFactory
{

    private $request;

    private $gameFromFormData;

    private $gameFromJsonOrXml;

    public function __construct(
        RequestStack $requestStack,
        GameRequestFromFormData $gameFromFormData,
        GameRequestFromJsonOrXml $gameFromJsonOrXml
    ) {
        $this->request = $requestStack->getCurrentRequest();

        $this->gameFromFormData = $gameFromFormData;

        $this->gameFromJsonOrXml = $gameFromJsonOrXml;
    }


    public function createBuilder() : IGameRequestBuilder
    {

        if (in_array($this->request->getContentType(), ['json', 'xml'])) {
            return $this->gameFromJsonOrXml;
        }
        else {
            return $this->gameFromFormData;
        }
    }




}