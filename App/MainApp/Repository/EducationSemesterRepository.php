<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EducationSemester;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EducationSemester>
 *
 * @method EducationSemester|null find($id, $lockMode = null, $lockVersion = null)
 * @method EducationSemester|null findOneBy(array $criteria, array $orderBy = null)
 * @method EducationSemester[]    findAll()
 * @method EducationSemester[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationSemesterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationSemester::class);
    }

//    /**
//     * @return EducationSemester[] Returns an array of EducationSemester objects
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

//    public function findOneBySomeField($value): ?EducationSemester
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
