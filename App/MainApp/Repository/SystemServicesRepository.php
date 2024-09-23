<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\SystemServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SystemServices>
 *
 * @method SystemServices|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemServices|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemServices[]    findAll()
 * @method SystemServices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemServices::class);
    }

//    /**
//     * @return SystemSerivces[] Returns an array of SystemSerivces objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SystemSerivces
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
