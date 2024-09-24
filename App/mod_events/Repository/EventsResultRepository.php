<?php

namespace App\mod_events\Repository;

use App\mod_events\Entity\EventsResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\mod_events\Entity\EventsResult>
 *
 * @method EventsResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsResult[]    findAll()
 * @method EventsResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsResult::class);
    }

//    /**
//     * @return EventsResult[] Returns an array of EventsResult objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EventsResult
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
