<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\Reviews;
use App\Entity\Tracklist;
use App\Entity\User;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\EntityManager;
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
     * @throws \Doctrine\DBAL\DBALException
     */
    public function index(EntityManagerInterface $em, AlbumsRepository $albumsRepository)
    {
        $allComments = [];
      //  $repository = $em->getRepository(Reviews::class);
     //   $allComments = $repository->findBy($allComments, null, 3, null);
        $userComment = $albumsRepository->findByUserAndCommentTop3();
        $allAlbums = $albumsRepository->findByAllAlbums();



        return $this->render('views/albums.html.twig',
            [   'TopComments' => $allComments,
                'controller_name' => 'Albums',
                'user' => $userComment,
                'albums' => $allAlbums
            ]);

    }


}
