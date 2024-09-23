<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\AdmissionPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdmissionPlan>
 *
 * @method AdmissionPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdmissionPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdmissionPlan[]    findAll()
 * @method AdmissionPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdmissionPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdmissionPlan::class);
    }

    public function save(AdmissionPlan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdmissionPlan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AdmissionPlan[] Returns an array of AdmissionPlan objects
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

//    public function findOneBySomeField($value): ?AdmissionPlan
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
