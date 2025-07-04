<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Roles>
 *
 * @method Roles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roles[]    findAll()
 * @method Roles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roles::class);
    }

    public function save(Roles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Roles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Roles[] Returns an array of Roles objects
     * @throws \Doctrine\ORM\NonUniqueResultException
     */

    public function findAllActiveAsArray(): ?array
    {
        $result= $this->createQueryBuilder('fr')
            ->andWhere('fr.status = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        return $result;

    }
    /*public function findAllActiveAsArray(): ?array
    {
        $result= $this->createQueryBuilder('fr')
            ->andWhere('fr.status = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult(/*AbstractQuery::HYDRATE_ARRAY);
        foreach ($result as $role)
        {
            $rc[$role->getName()]=$role;
        }
        return $rc;
    }*/


//    /**
//     * @return Roles[] Returns an array of Roles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Roles
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
