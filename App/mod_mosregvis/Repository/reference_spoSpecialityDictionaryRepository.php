<?php


namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\reference_spoSpecialityDictionary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends reference_spoSpecialityDictionaryRepository<ServiceEntityRepository>
 * @method reference_spoSpecialityDictionary|null find($id, $lockMode = null, $lockVersion = null)
 * @method reference_spoSpecialityDictionary|null findOneBy(array $criteria, array $orderBy = null)
 * @method reference_spoSpecialityDictionary[]    findAll()
 * @method reference_spoSpecialityDictionary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class reference_spoSpecialityDictionaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, reference_spoSpecialityDictionary::class);
    }

    public function save(reference_spoSpecialityDictionary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(reference_spoSpecialityDictionary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return reference_spoSpecialityDictionary[] Returns an array of reference_spoSpecialityDictionary objects
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

//    public function findOneBySomeField($value): ?reference_spoSpecialityDictionary
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
