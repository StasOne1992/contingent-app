<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\LoginProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoginProvider>
 *
 * @method LoginProvider|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginProvider|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginProvider[]    findAll()
 * @method LoginProvider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginProviderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginProvider::class);
    }

//    /**
//     * @return LoginProvider[] Returns an array of LoginProvider objects
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

//    public function findOneBySomeField($value): ?LoginProvider
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
