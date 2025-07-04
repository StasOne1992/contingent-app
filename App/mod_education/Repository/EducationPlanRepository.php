<?php

namespace App\mod_education\Repository;

use App\mod_education\Entity\EducationPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EducationPlan>
 *
 * @method EducationPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method EducationPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method EducationPlan[]    findAll()
 * @method EducationPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationPlan::class);
    }

//    /**
//     * @return EducationPlan[] Returns an array of EducationPlan objects
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

//    public function findOneBySomeField($value): ?EducationPlan
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
