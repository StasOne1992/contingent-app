<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\ModMosregVis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModMosregVis>
 *
 * @method ModMosregVis|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModMosregVis|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModMosregVis[]    findAll()
 * @method ModMosregVis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModMosregVisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModMosregVis::class);
    }

    //    /**
    //     * @return ModMosregVis[] Returns an array of ModMosregVis objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ModMosregVis
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
