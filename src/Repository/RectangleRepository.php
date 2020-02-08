<?php

namespace App\Repository;

use App\Entity\Rectangle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Rectangle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rectangle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rectangle[]    findAll()
 * @method Rectangle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RectangleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rectangle::class);
    }

    // /**
    //  * @return Rectangle[] Returns an array of Rectangle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rectangle
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
