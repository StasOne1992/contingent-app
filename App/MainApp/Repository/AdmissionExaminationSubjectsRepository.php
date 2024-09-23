<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\AdmissionExaminationSubjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdmissionExaminationSubjects>
 *
 * @method AdmissionExaminationSubjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdmissionExaminationSubjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdmissionExaminationSubjects[]    findAll()
 * @method AdmissionExaminationSubjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdmissionExaminationSubjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdmissionExaminationSubjects::class);
    }

//    /**
//     * @return AdmissionExaminationSubjects[] Returns an array of AdmissionExaminationSubjects objects
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

//    public function findOneBySomeField($value): ?AdmissionExaminationSubjects
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
