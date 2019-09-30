<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\League;
use App\Entity\Sport;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function getGamesBetweenDates(
        Sport $sport,
        \DateTime $dateTime1,
        \DateTime $dateTime2,
        League $league = null,
        Team $team1 = null,
        Team $team2 = null
    ) {
        $qb = $this->createQueryBuilder('g')
            ->where('g.date BETWEEN :from AND :to')
            ->andWhere('g.sport = :s')
            ->setParameter('s', $sport)
            ->setParameter('form', $dateTime1)
            ->setParameter('to', $dateTime2);

        if ($league) {
            $qb->andWhere('g.league = :l');
            $qb->setParameter('l', $league);
        }

        if ($team1) {
            $qb->andWhere('g.team1 = :t1');
            $qb->setParameter('t1', $team1);
        }

        if ($team2) {
            $qb->andWhere('g.team2 = :t2');
            $qb->setParameter('t2', $team2);
        }

        return $qb->getQuery()->getSingleResult();

    }


    // /**
    //  * @return Game[] Returns an array of Game objects
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
    public function findOneBySomeField($value): ?Game
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
