<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\EducationYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EducationYear>
 *
 * @method EducationYear|null find($id, $lockMode = null, $lockVersion = null)
 * @method EducationYear|null findOneBy(array $criteria, array $orderBy = null)
 * @method EducationYear[]    findAll()
 * @method EducationYear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EducationYearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationYear::class);
    }

//    /**
//     * @return EducationYear[] Returns an array of EducationYear objects
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

//    public function findOneBySomeField($value): ?EducationYear
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
