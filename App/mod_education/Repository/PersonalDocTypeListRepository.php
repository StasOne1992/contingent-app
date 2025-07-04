<?php

namespace App\mod_education\Repository;

use App\mod_education\Entity\PersonalDocTypeList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\mod_education\Entity\PersonalDocTypeList>
 *
 * @method PersonalDocTypeList|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalDocTypeList|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalDocTypeList[]    findAll()
 * @method PersonalDocTypeList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalDocTypeListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalDocTypeList::class);
    }

    public function save(PersonalDocTypeList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PersonalDocTypeList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PersonalDocTypeList[] Returns an array of PersonalDocTypeList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PersonalDocTypeList
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
