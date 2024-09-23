<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\MosregVISCollege;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MosregVISCollege>
 *
 * @method MosregVISCollege|null find($id, $lockMode = null, $lockVersion = null)
 * @method MosregVISCollege|null findOneBy(array $criteria, array $orderBy = null)
 * @method MosregVISCollege[]    findAll()
 * @method MosregVISCollege[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MosregVISCollegeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MosregVISCollege::class);
    }

    public function save(MosregVISCollege $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MosregVISCollege $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MosregVISCollege[] Returns an array of MosregVISCollege objects
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

//    public function findOneBySomeField($value): ?MosregVISCollege
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
