<?php


namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\reference_studyDiscipline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends reference_studyDisciplineRepository<ServiceEntityRepository>
 * @method reference_studyDiscipline|null find($id, $lockMode = null, $lockVersion = null)
 * @method reference_studyDiscipline|null findOneBy(array $criteria, array $orderBy = null)
 * @method reference_studyDiscipline[]    findAll()
 * @method reference_studyDiscipline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class reference_studyDisciplineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, reference_studyDiscipline::class);
    }

    public function save(reference_studyDiscipline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(reference_studyDiscipline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return reference_studyDiscipline[] Returns an array of reference_studyDiscipline objects
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

//    public function findOneBySomeField($value): ?reference_studyDiscipline
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
