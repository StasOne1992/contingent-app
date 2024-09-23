<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\AdmissionExaminationResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdmissionExaminationResult>
 *
 * @method AdmissionExaminationResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdmissionExaminationResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdmissionExaminationResult[]    findAll()
 * @method AdmissionExaminationResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdmissionExaminationResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdmissionExaminationResult::class);
    }

//    /**
//     * @return AdmissionExaminationResult[] Returns an array of AdmissionExaminationResult objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AdmissionExaminationResult
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
