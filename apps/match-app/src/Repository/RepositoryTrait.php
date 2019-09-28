<?php

namespace App\Repository;

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