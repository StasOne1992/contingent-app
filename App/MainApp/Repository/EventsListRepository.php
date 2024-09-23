<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EventsList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventsList>
 *
 * @method EventsList|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsList|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsList[]    findAll()
 * @method EventsList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsList::class);
    }

//    /**
//     * @return EventsList[] Returns an array of EventsList objects
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

//    public function findOneBySomeField($value): ?EventsList
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
