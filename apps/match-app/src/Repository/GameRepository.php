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
            ->setParameter('from', $dateTime1)
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

        $results = $qb->getQuery()->getResult();

        $sql = $qb->getQuery()->getSQL();

        return count($results) > 0 ? array_shift($results) : null;

    }


    public function getRandomGame(\DateTime $dateTime1 = null, \DateTime $dateTime2 = null, $source = null)
    {
        $qb = $this->createQueryBuilder('g')
            ->join('g.gameBuffers', 'gB');

        if ($dateTime1) {
            $qb->andWhere('g.date >= :from');
            $qb->setParameter('from', $dateTime1);
        }

        if ($dateTime2) {
            $qb->andWhere('g.date <= :to');
            $qb->setParameter('to', $dateTime2);
        }

        if ($source) {
            $qb->andWhere('gB.source = :source');
            $qb->setParameter('source', $source);
        }

        $qb->groupBy('g');

        $games = $qb->getQuery()->getResult();

        if (!count($games)) return null;

        $k = rand(0, count($games) - 1);

        return $games[$k];
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
