<?php

namespace App\Repository;

use App\Entity\Itranslated;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

trait RepositoryTrait
{
    public function flush()
    {
        $this->_em->flush();
    }

    public function persist($object)
    {
        $this->_em->persist($object);
    }
}