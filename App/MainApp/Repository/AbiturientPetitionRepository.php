<?php

namespace App\MainApp\Repository;

use App\MainApp\Entity\AbiturientPetition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbiturientPetition>
 *
 * @method AbiturientPetition|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbiturientPetition|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbiturientPetition[]    findAll()
 * @method AbiturientPetition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbiturientPetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbiturientPetition::class);
    }

    public function save(AbiturientPetition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbiturientPetition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array[] Returns an array of AbiturientPetition GUID's
     */
    public function getAllGUID(): array
    {
        $repoData = $this->findAll();
        $result = array();
        foreach ($repoData as $data) {
            $result[] = $data->getGUID();
        }
        return $result;
    }

    /**
     * @return array[] Returns an array of AbiturientPetition for load to WebSite
     */
    public function getPetitionToSite(): array
    {
        $result = array();
        return $result;
    }

    /**
     * @return int Returns integer - count unique people in admission
     * @throws Exception
     */
    public function getUniquePetitionCount($admission): int
    {
        $connection = $this->getEntityManager()->getConnection();
        $query = "SELECT COUNT(DISTINCT (snils))
	                    FROM public.person 
	                    WHERE id in (SELECT person_id FROM public.abiturient_petition  WHERE   admission_id=$admission);";
        $resultSet = $connection->executeQuery($query);
        return $resultSet->fetchOne();
    }

    /**
     * @throws Exception
     */
    public function getRegionAcceptedPetitionCount($admission): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $query = "SELECT public.regions.name AS Title,count(abiturient_petition.id) AS count , public.regions.code FROM public.abiturient_petition
        LEFT JOIN public.regions on public.abiturient_petition.region_id=regions.id 
        LEFT JOIN public.abiturient_petition_status on public.abiturient_petition_status.id=public.abiturient_petition.status_id
        where admission_id=$admission and status_id=(select id FROM public.abiturient_petition_status where name='ACCEPTED')
        group by region_id, status_id,abiturient_petition_status.name,public.regions.name, public.regions.code
        order by count DESC";
        $resultSet = $connection->executeQuery($query);
        return $resultSet->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function getRegionPetitionCount($admission): array
    {
        $connection = $this->getEntityManager()->getConnection();
        $query = "select region_id,count(abiturient_petition.id), abiturient_petition_status.name from public.abiturient_petition
        LEFT JOIN public.regions on public.abiturient_petition.region_id=regions.id 
        LEFT JOIN public.abiturient_petition_status on public.abiturient_petition_status.id=public.abiturient_petition.status_id
        where admission_id=$admission
        group by region_id, status_id,abiturient_petition_status.name
        order by region_id ASC";
        $resultSet = $connection->executeQuery($query);
        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return AbiturientPetition[] Returns an array of AbiturientPetition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AbiturientPetition
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
