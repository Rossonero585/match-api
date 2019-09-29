<?php

namespace App\Service;


use App\Entity\Itranslated;
use Doctrine\Common\Collections\ArrayCollection;

class Levenshtein
{

    private $transliterator;

    public function __construct(Transliterator $transliterator)
    {
        $this->transliterator = $transliterator;
    }

    public function findSimilarUsingLevenshtein(ArrayCollection $collection, $needle, $lang)
    {
        $distances = array_map(function (Itranslated $item) use($needle, $lang) {

            if ($lang == 'ru') {

                $currNeedle = $needle;
                $name = $item->getNameRu();

                if (!$name) {
                    $currNeedle = $this->transliterator->cyr2Lat($needle);
                    $name = $item->getNameEn();
                }

            }
            else {

                $currNeedle = $needle;
                $name = $item->getNameEn();

                if (!$name) {
                    $currNeedle = $this->transliterator->lat2Cyr($needle);
                    $name = $item->getNameRu();
                }
            }

            return levenshtein($name, $currNeedle);

        }, $collection->toArray());

        asort($distances);

        $minDistanceKey = array_key_first($distances);

        $minDistance = $distances[$minDistanceKey];

        /** @var Itranslated $minDistanceItem */
        $minDistanceItem = $collection->get($minDistanceKey);

        if ($minDistance < mb_strlen($needle) / 2) {
            return $minDistanceItem;
        }
        else {
            return $minDistanceItem;
        }
    }
}