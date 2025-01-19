<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Npub\Gos\Snils;

/**
 * @extends ServiceEntityRepository<Person>
 *
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * //     * @return Person[] Returns an array of Person objects
     * //     */
    public function findBySnils(Snils $snils): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.snils = :val')
            ->setParameter('val', $snils->getID())
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Person[] Returns an array of Person objects
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

//    public function findOneBySomeField($value): ?Person
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
