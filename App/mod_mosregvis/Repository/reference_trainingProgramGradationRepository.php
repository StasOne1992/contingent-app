<?php


namespace App\mod_mosregvis\Repository;

use App\mod_mosregvis\Entity\reference_trainingProgramGradation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends reference_trainingProgramGradationRepository<ServiceEntityRepository>
 * @method reference_trainingProgramGradation|null find($id, $lockMode = null, $lockVersion = null)
 * @method reference_trainingProgramGradation|null findOneBy(array $criteria, array $orderBy = null)
 * @method reference_trainingProgramGradation[]    findAll()
 * @method reference_trainingProgramGradation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class reference_trainingProgramGradationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, reference_trainingProgramGradation::class);
    }

    public function save(reference_trainingProgramGradation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(reference_trainingProgramGradation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return reference_trainingProgramGradation[] Returns an array of reference_trainingProgramGradation objects
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

//    public function findOneBySomeField($value): ?reference_trainingProgramGradation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
