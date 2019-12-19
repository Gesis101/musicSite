<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AlbumsController extends AbstractController
{
    /**
     * @Route("/albums/{id}", name="albums")
     * @Route("/albums");
     */
    public function index()
    {
        return $this->render('views/albums.html.twig', [
            'controller_name' => 'Albums',
        ]);
    }
}
