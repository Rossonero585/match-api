<?php

namespace App\Service;


use App\Entity\Itranslated;

class Levenshtein
{

    private $transliterator;

    public function __construct(Transliterator $transliterator)
    {
        $this->transliterator = $transliterator;
    }

    public function findSimilarUsingLevenshtein(array $collection, $needle, $lang, int $treshold = null)
    {
        if (!count($collection)) return null;

        $distances = array_map(function (Itranslated $item) use($needle, $lang) {

            return $this->getLevensteinDistance($item, $needle, $lang);

        }, $collection);

        asort($distances);

        $minDistanceKey = array_key_first($distances);

        $minDistance = $distances[$minDistanceKey];

        /** @var Itranslated $minDistanceItem */
        $minDistanceItem = $collection[$minDistanceKey];

        if ($treshold) {
            return $minDistance <= $treshold ? $minDistanceItem : null;
        }
        else {
            return $minDistanceItem;
        }
    }

    public function getLevensteinDistance(Itranslated $item, $needle, $lang)
    {
        if ($lang == 'ru') {

            $needle = $this->transliterator->cyr2Lat($needle);

            if ($item->getNameRu()) {
                $name = $this->transliterator->cyr2Lat($item->getNameRu());
            }
            else {
                $name = $item->getNameEn();
            }
        }
        else {

            $name = $item->getNameEn();

            if (!$name) {
                $name = $this->transliterator->cyr2Lat($item->getNameRu());
            }
        }

        $name = str_replace(' ', '', $name);
        $needle = str_replace(' ', '', $needle);

        return levenshtein($name, $needle);
    }
}