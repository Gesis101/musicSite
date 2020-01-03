<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ReviewsController extends AbstractController
{
    /**
     * @Route("/reviews", name="reviews")
     */
    public function index()
    {
        return $this->render('reviews/register.html.twig', [
            'controller_name' => 'ReviewsController',
        ]);
    }
}
