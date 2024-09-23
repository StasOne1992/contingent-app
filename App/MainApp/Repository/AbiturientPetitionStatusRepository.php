<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\AbiturientPetitionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbiturientPetitionStatus>
 *
 * @method AbiturientPetitionStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbiturientPetitionStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbiturientPetitionStatus[]    findAll()
 * @method AbiturientPetitionStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbiturientPetitionStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbiturientPetitionStatus::class);
    }

    public function save(AbiturientPetitionStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbiturientPetitionStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AbiturientPetitionStatus[] Returns an array of AbiturientPetitionStatus objects
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

//    public function findOneBySomeField($value): ?AbiturientPetitionStatus
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
