<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EventsPlaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventsPlaces>
 *
 * @method EventsPlaces|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsPlaces|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsPlaces[]    findAll()
 * @method EventsPlaces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsPlacesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsPlaces::class);
    }

//    /**
//     * @return EventsPlaces[] Returns an array of EventsPlaces objects
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

//    public function findOneBySomeField($value): ?EventsPlaces
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
