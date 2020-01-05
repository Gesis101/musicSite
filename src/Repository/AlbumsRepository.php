<?php

namespace App\Repository;

use App\Entity\Albums;
use App\Entity\Tracklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Albums|null find($id, $lockMode = null, $lockVersion = null)
 * @method Albums|null findOneBy(array $criteria, array $orderBy = null)
 * @method Albums[]    findAll()
 * @method Albums[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Albums::class);
    }

    // /**
    //  * @return Albums[] Returns an array of Albums objects
    //  */

    public function findByUserAndCommentTop3()
    {
     //   return $this->createQueryBuilder('a')
         //   ->select('u.username, r.user_comment')
          //  ->from('App\Entity\User', 'u')
          //  ->where('u.id = r.user_id')
        //    ->setMaxResults(3)
          //  ->getQuery()
       //     ->getResult();
        //just separate the logic so it also selects a single album and artist...
    }

    // /**
    //  * @return Albums[] Returns an array of Albums objects
    //  */
    public function findBySearch(?string $query){

        $result = $this->createQueryBuilder('a');

        if ($query) {
            $result->setParameter('query', $query)
                ->andWhere('a.artist LIKE :query OR a.category LIKE :query OR a.title LIKE :query OR a.songs LIKE :query');

        }

        return $result->orderBy('a.id')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Albums
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
