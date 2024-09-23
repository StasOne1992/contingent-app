<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\FamilyTypeList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FamilyTypeList>
 *
 * @method FamilyTypeList|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyTypeList|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyTypeList[]    findAll()
 * @method FamilyTypeList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyTypeListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyTypeList::class);
    }

    public function save(FamilyTypeList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FamilyTypeList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FamilyTypeList[] Returns an array of FamilyTypeList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FamilyTypeList
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
