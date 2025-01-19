<?php


namespace App\MainApp\Repository;

use App\MainApp\Entity\PersonDocumentCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonDocumentCategory>
 *
 * @method PersonDocumentCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonDocumentCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonDocumentCategory[]    findAll()
 * @method PersonDocumentCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonDocumentCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonDocumentCategory::class);
    }

    public function save(PersonDocumentCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PersonDocumentCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PersonDocumentCategory[] Returns an array of PersonDocumentCategory objects
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

//    public function findOneBySomeField($value): ?PersonDocumentCategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
