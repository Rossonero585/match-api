<?php

namespace App\Repository;


use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;

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


    private function fullTextSearch($table, $needle, $condition = '')
    {
        /** @var EntityManager $em */
        $em = $this->_em;

        $rsm = new ResultSetMapping();

        $rsm->addEntityResult($this->getClassName(), 'e');

        $rsm->addFieldResult('e', 'id', 'id');
        $rsm->addFieldResult('e', 'name_ru', 'nameRu');
        $rsm->addFieldResult('e', 'name_en', 'nameEn');

        $query = "SELECT id, name_ru, name_en FROM $table WHERE MATCH(name_ru, name_en) AGAINST (? IN NATURAL LANGUAGE MODE) ";

        if ($condition) $query .= " AND ".$condition;

        $query .= " LIMIT 5";

        $q = $em->createNativeQuery($query, $rsm);

        $q->setParameter(1, $needle);

        return $q->getResult(AbstractQuery::HYDRATE_OBJECT);
    }

}