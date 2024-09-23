<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\AdmissionExamination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdmissionExamination>
 *
 * @method AdmissionExamination|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdmissionExamination|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdmissionExamination[]    findAll()
 * @method AdmissionExamination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdmissionExaminationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdmissionExamination::class);
    }

//    /**
//     * @return AdmissionExamination[] Returns an array of AdmissionExamination objects
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

//    public function findOneBySomeField($value): ?AdmissionExamination
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
