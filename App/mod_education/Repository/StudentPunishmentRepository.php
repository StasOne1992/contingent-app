<?php

namespace App\mod_education\Repository;

use App\mod_education\Entity\StudentPunishment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\mod_education\Entity\StudentPunishment>
 *
 * @method StudentPunishment|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentPunishment|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentPunishment[]    findAll()
 * @method StudentPunishment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentPunishmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentPunishment::class);
    }

//    /**
//     * @return StudentPunishment[] Returns an array of StudentPunishment objects
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

//    public function findOneBySomeField($value): ?StudentPunishment
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
