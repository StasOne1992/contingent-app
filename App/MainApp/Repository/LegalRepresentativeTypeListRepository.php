<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\LegalRepresentativeTypeList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LegalRepresentativeTypeList>
 *
 * @method LegalRepresentativeTypeList|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalRepresentativeTypeList|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalRepresentativeTypeList[]    findAll()
 * @method LegalRepresentativeTypeList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalRepresentativeTypeListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalRepresentativeTypeList::class);
    }

    public function save(LegalRepresentativeTypeList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LegalRepresentativeTypeList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LegalRepresentativeTypeList[] Returns an array of LegalRepresentativeTypeList objects
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

//    public function findOneBySomeField($value): ?LegalRepresentativeTypeList
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
