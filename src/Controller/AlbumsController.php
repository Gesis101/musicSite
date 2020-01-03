<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AlbumsRepository;
use App\Repository\TracklistRepository;
class AlbumsController extends AbstractController
{
    /**
     * @Route("/albums", name="albums")
     * @Route("/albums");
     * @param EntityManagerInterface $em
     * @param AlbumsRepository $albumsRepository
     * @param TracklistRepository $tracklistRepository
     * @return Response
     */
    public function index(EntityManagerInterface $em, AlbumsRepository $albumsRepository, TracklistRepository $tracklistRepository)
    {
        $allComments = [];
        $repository = $em->getRepository(Reviews::class);
        $allComments = $repository->findBy($allComments, null, 3, null);
        $userComment = $albumsRepository->findByUserAndCommentTop3();
        $top3Tracks = $tracklistRepository->findByTop3SongsOfAlbum();
        return $this->render('views/albums.html.twig',
            [   'TopComments' => $allComments,
                'controller_name' => 'Albums',
                'user' => $userComment,
                'top3Tracks' => $top3Tracks
            ]);

    }
    /*public function getCommentOwner(EntityManagerInterface $entityManager){

       $query = $entityManager->createQueryBuilder()
            ->select('User.username')
            ->from('Review','')
            ->where('user.id = reviews.user.id');

       return $query->getQuery()->execute();
    }*/

}
