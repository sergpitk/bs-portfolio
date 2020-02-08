<?php

namespace App\Repository;

use App\Entity\RectanglesUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RectanglesUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method RectanglesUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method RectanglesUnit[]    findAll()
 * @method RectanglesUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RectanglesUnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RectanglesUnit::class);
    }

    // /**
    //  * @return RectanglesUnit[] Returns an array of RectanglesUnit objects
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
    public function findOneBySomeField($value): ?RectanglesUnit
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
