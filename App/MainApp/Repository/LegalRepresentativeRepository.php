<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\LegalRepresentative;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LegalRepresentative>
 *
 * @method LegalRepresentative|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalRepresentative|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalRepresentative[]    findAll()
 * @method LegalRepresentative[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalRepresentativeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalRepresentative::class);
    }

    public function save(LegalRepresentative $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LegalRepresentative $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LegalRepresentative[] Returns an array of LegalRepresentative objects
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

//    public function findOneBySomeField($value): ?LegalRepresentative
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
