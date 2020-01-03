<?php

namespace App\Repository;

use App\Entity\Tracklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tracklist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tracklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tracklist[]    findAll()
 * @method Tracklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TracklistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tracklist::class);
    }

    // /**
    //  * @return Tracklist[] Returns an array of Tracklist objects
    //  */

    public function findByTop3SongsOfAlbum()
    {
        return $this->createQueryBuilder('t')
            ->select('t.song')
            ->innerJoin('App\Entity\Albums', 'a')
            ->where('a.id = t.album_id')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

    }


    /*
    public function findOneBySomeField($value): ?Tracklist
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
