<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\LoginValues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoginValues>
 *
 * @method LoginValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginValues[]    findAll()
 * @method LoginValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginValuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginValues::class);
    }

//    /**
//     * @return LoginValues[] Returns an array of LoginValues objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LoginValues
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
