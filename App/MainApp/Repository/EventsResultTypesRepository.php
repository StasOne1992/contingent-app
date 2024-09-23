<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EventsResultTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventsResultTypes>
 *
 * @method EventsResultTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsResultTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsResultTypes[]    findAll()
 * @method EventsResultTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsResultTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsResultTypes::class);
    }

//    /**
//     * @return EventsResultType[] Returns an array of EventsResultType objects
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

//    public function findOneBySomeField($value): ?EventsResultType
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
