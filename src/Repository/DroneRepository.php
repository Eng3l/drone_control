<?php

namespace App\Repository;

use App\Entity\Drone;
use App\Entity\DroneState;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Drone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Drone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Drone[]    findAll()
 * @method Drone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DroneRepository extends ServiceEntityRepository
{
    const ITEMS_PER_PAGE = 50;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Drone::class);
    }

    public function getDronesByAvailability($page)
    {
        $first = ($page - 1) * self::ITEMS_PER_PAGE;

        return $this->createQueryBuilder('d')
            ->andWhere('d.state <= :state')
            ->setParameter('state', DroneState::LOADING)
            ->setFirstResult($first)
            ->setMaxResults(self::ITEMS_PER_PAGE)
            ->getQuery()
            ->getResult()
        ;
    }
}
