<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SportFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $sport = new Sport();
        $sport->setNameEn('football')->setNameRu('футбол');

        $manager->persist($sport);

        $sport = new Sport();
        $sport->setNameEn('basketball')->setNameRu('баскетбол');

        $manager->persist($sport);

        $sport = new Sport();
        $sport->setNameEn('volleyball')->setNameRu('волейбол');

        $manager->persist($sport);

        $sport = new Sport();
        $sport->setNameEn('hockey')->setNameRu('хоккей');

        $manager->persist($sport);

        $manager->flush();
    }

}