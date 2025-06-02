<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\SpoPetition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SpoPetition>
 *
 * @method SpoPetition|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpoPetition|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpoPetition[]    findAll()
 * @method SpoPetition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpoPetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpoPetition::class);
    }

    public function save(SpoPetition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SpoPetition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SpoPetition[] Returns an array of SpoPetition objects
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

//    public function findOneBySomeField($value): ?SpoPetition
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
