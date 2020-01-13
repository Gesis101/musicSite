<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\Review;
use App\Entity\User;
use App\Repository\ReviewRepository;
use App\Repository\SongsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AlbumsRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use function MongoDB\BSON\toJSON;

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
    public function index(EntityManagerInterface $em, ReviewRepository $reviewsRepository, Request $request, AlbumsRepository $albumsRepository, UserInterface $user)
    {
        $err = null;
        //! POST Values from Views.
        $q = $request->query->get('query');
        $q2 = $request->query->get('rating');
        $q3 = $request->query->get('genre');
        $fav = $request->query->get('add');
        $noneFav = $request->query->get('remove');
        $favourite = $request->query->get('favourite');
        $userId = $user->getId();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($userId);
        $user = $user->getAlbumFav();
        if (isset($fav)){
            $albums = $albumsRepository->find($fav);
            $albums->addUserFav($this->getUser());
            $em->flush();
        }
        if (isset($noneFav)){
            $albums = $albumsRepository->find($noneFav);
            $albums->removeUserFav($this->getUser());
            $em->flush();
        }


        $query = null;
        if ($q){
            $query = $q;
        } elseif($q2){
            $query = $q2;
        } elseif ($q3){
            $query = $q3;
        }
        $relatedToReviews = $reviewsRepository->findBySearch($query);

        //Filters
        if (isset($favourite)) {

        }

       //If no results found return error and find all instead.
       if (!$relatedToReviews){
           $err = 'Sorry, no relevant results found';
       }

        return $this->render('views/albums.html.twig',
            [
                'controller_name' => 'Albums',
                'user' => 'comment',
                'albums' => $relatedToReviews,
                'error' => $err,
                'userFav'=> $user
            ]);

    }

    /**
     * @Route("/albums/{id}", name="album_show", requirements={"id":"\d+"}))
     * @param Albums $albums
     * @return Response
     */
    public function show( Albums $albums, Request $request, UserInterface $user)
    {
        //Search
        $comment = $request->query->get('comment');
        $userId = $user->getId();
        $em = $this->getDoctrine()->getManager();
        if ($comment) {
           $review = new Review();
           $review->setAuthorName($user)
               ->setComment($comment)
               ->setPostedAt(new \DateTime())
               ->setUserRating(5)
               ->setAlbums($albums);

           $em->persist($review);
           $em->flush();

        }
        return $this->render('views/albums_show.html.twig',
            ['albums' =>$albums, 'controller_name' => 'album_show']);
    }

}
