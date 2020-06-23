<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ApiTokenRepository;
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
    public function index(UserRepository $userRepository, UserInterface $userId, ApiTokenRepository $apiTokenRepository)
    {
        $userToken = $apiTokenRepository->getUserAPIToken($userId);
        $user = $userRepository->findByAll();
        $userId = $userId->getId();
        return $this->render('views/account.html.twig', [
            'controller_name' => 'Account',
            'users' => $user,
            'userId' => $userId,
            'apiToken' => $userToken[0]['token']
        ]);
    }

    private function getUserAPIToken(){

  }
}
