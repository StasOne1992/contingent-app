<?php

namespace App\MainApp\Repository;

use App\Entity\ContingentDocContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContingentDocContent>
 *
 * @method ContingentDocContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContingentDocContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContingentDocContent[]    findAll()
 * @method ContingentDocContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContingentDocContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContingentDocContent::class);
    }

    public function save(ContingentDocContent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContingentDocContent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ContingentDocContent[] Returns an array of ContingentDocContent objects
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

//    public function findOneBySomeField($value): ?ContingentDocContent
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
