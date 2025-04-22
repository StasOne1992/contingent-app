<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\modMosregVis_Configuration ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends modMosregVis_Configuration Repository<ServiceEntityRepository>
 * @method modMosregVis_Configuration |null find($id, $lockMode = null, $lockVersion = null)
 * @method modMosregVis_Configuration |null findOneBy(array $criteria, array $orderBy = null)
 * @method modMosregVis_Configuration []    findAll()
 * @method modMosregVis_Configuration []    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class modMosregVis_ConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, modMosregVis_Configuration ::class);
    }

    public function save(modMosregVis_Configuration  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(modMosregVis_Configuration  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return $modMosregVis_Configuration_Configuration [] Returns an array of $modMosregVis_Configuration_Configuration  objects
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

//    public function findOneBySomeField($value): ?$modMosregVis_Configuration_Configuration
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
