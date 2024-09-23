<?php


namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\reference_SpoEducationYear;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends reference_SpoEducationYearRepository<ServiceEntityRepository>
 * @method reference_SpoEducationYear|null find($id, $lockMode = null, $lockVersion = null)
 * @method reference_SpoEducationYear|null findOneBy(array $criteria, array $orderBy = null)
 * @method reference_SpoEducationYear[]    findAll()
 * @method reference_SpoEducationYear[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class reference_SpoEducationYearRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, reference_SpoEducationYear::class);
    }

    public function save(reference_SpoEducationYear $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(reference_SpoEducationYear $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return reference_SpoEducationYear[] Returns an array of reference_SpoEducationYear objects
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

//    public function findOneBySomeField($value): ?reference_SpoEducationYear
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
