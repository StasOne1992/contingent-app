<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\ContingentDocumentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContingentDocumentType>
 *
 * @method ContingentDocumentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContingentDocumentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContingentDocumentType[]    findAll()
 * @method ContingentDocumentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContingentDocumentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContingentDocumentType::class);
    }

    public function save(ContingentDocumentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContingentDocumentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ContingentDocumentType[] Returns an array of ContingentDocumentType objects
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

//    public function findOneBySomeField($value): ?ContingentDocumentType
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
