<?php

namespace App\Repository;

use App\Entity\GameBuffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GameBuffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameBuffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameBuffer[]    findAll()
 * @method GameBuffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameBufferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameBuffer::class);
    }

    // /**
    //  * @return GameBuffer[] Returns an array of GameBuffer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameBuffer
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
