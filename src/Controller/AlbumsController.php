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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AlbumsRepository;
class AlbumsController extends AbstractController
{


    /**
     * @Route("/albums", name="albums")
     * @Route("/albums");
     * @param EntityManagerInterface $em
     * @param ReviewRepository $reviewsRepository
     * @param Request $request
     * @param AlbumsRepository $albumsRepository
     * @return Response
     */
    public function index(EntityManagerInterface $em, ReviewRepository $reviewsRepository, Request $request, AlbumsRepository $albumsRepository)
    {
        $err = null;

        $q = $request->query->get('query');
        $q2 = $request->query->get('rating');
        $q3 = $request->query->get('genre');

        $query = null;
        if ($q){
            $query = $q;
        } elseif($q2){
            $query = $q2;
        } elseif ($q3){
            $query = $q3;
        }
        $relatedToReviews = $reviewsRepository->findBySearch($query);


       //If no results found return error and find all instead.
       if (!$relatedToReviews){
           $relatedToReviews = $reviewsRepository->findAll();
           $err = 'Sorry, no relevant results found';
       }

        return $this->render('views/albums.html.twig',
            [
                'controller_name' => 'Albums',
                'user' => 'comment',
                'albums' => $relatedToReviews,
                'error' => $err
            ]);

    }

    /**
     * @Route("/albums/{id}", name="album_show", requirements={"id":"\d+"}))
     * @param Albums $albums
     * @return Response
     */
    public function show(Albums $albums)
    {

        return $this->render('views/albums_show.html.twig',
            ['albums' =>$albums,
                'controller_name' => 'album_show']);
    }

}
