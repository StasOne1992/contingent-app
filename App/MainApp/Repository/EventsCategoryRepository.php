<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EventsCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventsCategory>
 *
 * @method EventsCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsCategory[]    findAll()
 * @method EventsCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsCategory::class);
    }

//    /**
//     * @return EventsCategory[] Returns an array of EventsCategory objects
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

//    public function findOneBySomeField($value): ?EventsCategory
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
