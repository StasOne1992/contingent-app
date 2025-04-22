<?php

namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\modMosregVis_College;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<modMosregVis_College>
 *
 * @method modMosregVis_College|null find($id, $lockMode = null, $lockVersion = null)
 * @method modMosregVis_College|null findOneBy(array $criteria, array $orderBy = null)
 * @method modMosregVis_College[]    findAll()
 * @method modMosregVis_College[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class modMosregVis_CollegeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, modMosregVis_College::class);
    }

    public function save(modMosregVis_College $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(modMosregVis_College $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return modMosregVis_College[] Returns an array of modMosregVis_College objects
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

//    public function findOneBySomeField($value): ?modMosregVis_College
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
