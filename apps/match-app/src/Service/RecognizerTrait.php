<?php

namespace App\Service;

trait RecognizerTrait
{
    private function prepareNameForSearch($name, $lang)
    {
        if ($lang == 'en') {
            $addName = $this->transliterator->lat2Cyr($name);
        } else {
            $addName = $this->transliterator->cyr2Lat($name);
        }

        return $name." ".$addName;
    }

    private function toLowerCase($name)
    {
        return mb_strtolower($name);
    }
}