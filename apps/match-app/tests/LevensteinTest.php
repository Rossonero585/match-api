<?php

namespace App\Tests;

use App\Entity\Sport;
use App\Service\Levenshtein;
use App\Service\Transliterator;
use PHPUnit\Framework\TestCase;

class LevensteinTest extends TestCase
{

    public function testSimple()
    {
        $lev = new Levenshtein(
            new Transliterator()
        );

        $col = [
            (new Sport())->setNameEn('football')->setNameRu('Футбоооооол'),
            (new Sport())->setNameEn('footbll')->setNameRu('Футбоооол'),
            (new Sport())->setNameEn('footbll123')->setNameRu('Футбоол')
        ];


        $g = $lev->findSimilarUsingLevenshtein($col, 'Футбол', 'ru');


        $this->assertEquals('Футбоол', $g->getNameRu());
    }

    public function testHarder()
    {
        $lev = new Levenshtein(
            new Transliterator()
        );

        $col = [
            (new Sport())->setNameEn('football')->setNameRu('Футбоооооол'),
            (new Sport())->setNameEn('footbll')->setNameRu('Футбоооол'),
            (new Sport())->setNameEn('Futbol')
        ];


        $g = $lev->findSimilarUsingLevenshtein($col, 'Футбол', 'ru');


        $this->assertEquals('', $g->getNameRu());
    }

}
