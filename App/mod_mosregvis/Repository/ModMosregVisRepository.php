<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\ModMosregVis ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ModMosregVis Repository<ServiceEntityRepository>
 * @method ModMosregVis |null find($id, $lockMode = null, $lockVersion = null)
 * @method ModMosregVis |null findOneBy(array $criteria, array $orderBy = null)
 * @method ModMosregVis []    findAll()
 * @method ModMosregVis []    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModMosregVisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModMosregVis ::class);
    }

    public function save(ModMosregVis  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ModMosregVis  $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ModMosregVis [] Returns an array of ModMosregVis  objects
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

//    public function findOneBySomeField($value): ?ModMosregVis 
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
