<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EducationSubjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EducationSubjects>
 *
 * @method EducationSubjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method EducationSubjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method EducationSubjects[]    findAll()
 * @method EducationSubjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationSubjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationSubjects::class);
    }

//    /**
//     * @return EducationSubjects[] Returns an array of EducationSubjects objects
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

//    public function findOneBySomeField($value): ?EducationSubjects
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
