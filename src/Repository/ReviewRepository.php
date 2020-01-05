<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use ErrorException;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    // /**
    //  * @return Review[] Returns an array of Review objects
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
    // /**
    //  * @return Review[] Returns an array of Review objects
    //  */
    public function findBySearch(?string $query){

        $result = $this->createQueryBuilder('r')
        ->innerJoin('r.albums', 'a')
            ->innerJoin('a.songs', 's');

        if ($query) {
                $result->setParameter('query', $query)
                    ->orWhere('a.artist LIKE :query OR a.genre LIKE :query OR a.title LIKE :query OR s.song_name LIKE :query OR a.average_rating = :query');

            }
//            if (!$result->getQuery()->getResult()){
//               return $result = $this->findAll();
//            }



        return $result
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Review
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
