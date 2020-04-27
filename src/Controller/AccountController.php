<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserRepository $userRepository, UserInterface $userId)
    {
        $user = $userRepository->findByAll();
        $userId = $userId->getId();
        return $this->render('views/account.html.twig', [
            'controller_name' => 'Account',
            'users' => $user,
            'userId' => $userId
        ]);
    }
}
