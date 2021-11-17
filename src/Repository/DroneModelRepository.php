<?php

namespace App\Repository;

use App\Entity\DroneModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DroneModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method DroneModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method DroneModel[]    findAll()
 * @method DroneModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DroneModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DroneModel::class);
    }

    // /**
    //  * @return DroneModel[] Returns an array of DroneModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DroneModel
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
