<?php

namespace App\Repository;

use App\Entity\BatteryLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BatteryLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BatteryLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BatteryLog[]    findAll()
 * @method BatteryLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BatteryLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BatteryLog::class);
    }

    // /**
    //  * @return BatteryLog[] Returns an array of BatteryLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BatteryLog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
