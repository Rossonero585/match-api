<?php

namespace App\Service;

use App\Model\GameBufferRequest;

interface IGameRequestBuilder
{
    function getGameRequest() : GameBufferRequest;

    function getGameRequests() : array;
}