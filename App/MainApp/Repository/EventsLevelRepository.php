<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EventsLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventsLevel>
 *
 * @method EventsLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsLevel[]    findAll()
 * @method EventsLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsLevel::class);
    }

//    /**
//     * @return EventsLevel[] Returns an array of EventsLevel objects
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

//    public function findOneBySomeField($value): ?EventsLevel
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
