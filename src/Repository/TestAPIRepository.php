<?php

namespace App\Repository;

use App\Entity\TestAPI;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TestAPI|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestAPI|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestAPI[]    findAll()
 * @method TestAPI[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestAPIRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestAPI::class);
    }

    // /**
    //  * @return TestAPI[] Returns an array of TestAPI objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TestAPI
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
