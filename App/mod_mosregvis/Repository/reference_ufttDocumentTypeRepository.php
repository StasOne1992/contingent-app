<?php


namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\reference_ufttDocumentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends reference_ufttDocumentTypeRepository<ServiceEntityRepository>
 * @method reference_ufttDocumentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method reference_ufttDocumentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method reference_ufttDocumentType[]    findAll()
 * @method reference_ufttDocumentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class reference_ufttDocumentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, reference_ufttDocumentType::class);
    }

    public function save(reference_ufttDocumentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(reference_ufttDocumentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return reference_ufttDocumentType[] Returns an array of reference_ufttDocumentType objects
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

//    public function findOneBySomeField($value): ?reference_ufttDocumentType
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
