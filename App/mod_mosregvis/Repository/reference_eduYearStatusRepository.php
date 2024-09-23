<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\reference_eduYearStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends reference_eduYearStatusRepository<ServiceEntityRepository>
 * @method reference_eduYearStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method reference_eduYearStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method reference_eduYearStatus[]    findAll()
 * @method reference_eduYearStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class reference_eduYearStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, reference_eduYearStatus::class);
    }

    public function save(reference_eduYearStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(reference_eduYearStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return reference_eduYearStatus[] Returns an array of reference_eduYearStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?reference_eduYearStatus
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
