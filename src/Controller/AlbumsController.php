<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\Review;
use App\Entity\User;
use App\Repository\ReviewRepository;
use App\Repository\SongsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AlbumsRepository;
class AlbumsController extends AbstractController
{


    /**
     * @Route("/albums", name="albums")
     * @Route("/albums");
     * @param EntityManagerInterface $em
     * @param ReviewRepository $reviewsRepository
     * @return Response
     */
    public function index(EntityManagerInterface $em, ReviewRepository $reviewsRepository, SongsRepository $songsRepository)
    {

       $relatedToReviews = $reviewsRepository->findAll();
        return $this->render('views/albums.html.twig',
            [
                'controller_name' => 'Albums',
                'user' => 'comment',
                'albums' => $relatedToReviews,
            ]);

    }


}
