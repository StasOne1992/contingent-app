<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\ModMosregVis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends modMosregVisRepository<ServiceEntityRepository>
 * @method modMosregVis|null find($id, $lockMode = null, $lockVersion = null)
 * @method modMosregVis|null findOneBy(array $criteria, array $orderBy = null)
 * @method modMosregVis[]    findAll()
 * @method modMosregVis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class modMosregVisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, modMosregVis::class);
    }

    public function save(modMosregVis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(modMosregVis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return modMosregVis[] Returns an array of modMosregVis objects
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

//    public function findOneBySomeField($value): ?modMosregVis
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
