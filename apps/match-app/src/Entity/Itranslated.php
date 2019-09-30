<?php

namespace App\Entity;

interface Itranslated
{
    public function getNameEn() : ?string;

    public function getNameRu() : ?string;

    public function setNameEn(string $s);

    public function setNameRu(string $s);
}