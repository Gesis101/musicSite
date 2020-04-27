<?php

namespace App\Controller;

use App\Entity\Albums;
use App\Entity\User;
use App\Repository\AlbumsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param UserRepository $userRepository
     * @param Request $request
     * @param AlbumsRepository $albumsRepository
     * @return Response
     */
    public function show(UserRepository $userRepository, Request $request, AlbumsRepository $albumsRepository)
    {
        $users = $userRepository->findByAll();
        $album = $albumsRepository->findByAll();
        $userId = $request->query->get('removeUser');
        if (isset($userId)) {

        }
        return $this->render('views/admin.html.twig', [
            'controller_name' => 'AdminPanelController',
            'users' => $users,
            'albums' => $album
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="user_edit")
     * @param int $id
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    public function edit(int $id, UserRepository $userRepository, Request $request)
    {
        $success = null;
        if ($request->getMethod() == 'POST' && isset($_POST['username'])) {
            $em = $this->getDoctrine()->getManager();
            $edit = $em->getRepository(User::class)->find($id);
            if (!$edit) {
                throw $this->createNotFoundException('User not found');
            }
            $edit->setUsername($_POST['username']);
            $edit->setEmail($_POST['email']);
            $userRepository->upgradePassword($edit, $_POST['password']);
            $em->persist($edit);
            $em->flush();
            $success = 'User successfully updated';
        }

        $user = $userRepository->find($id);
        return $this->render('views/admin_edit.html.twig', [
            'controller_name' => 'user edit',
            'user' => $user,
            'success' => $success
        ]);
    }

    /**
     * @Route("/admin/remove/{id}", name="remove")
     * @param int $id
     * @return Response
     */
    public function removeUser(int $id, UserRepository $userRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $removeUser = $em->getRepository(User::class)->find($id);
        $em->remove($removeUser);
      //  $em->persist($removeUser);
        $em->flush();

        return $this->redirectToRoute('admin');

    }

    /**
     * @Route("/remove/album/{id}", name="removeAlbum")
     * @param int $id
     * @return Response
     */
    public function remove(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $removeAlbum = $em->getRepository(Albums::class)->find($id);
        $em->remove($removeAlbum);
        //  $em->persist($removeUser);
        $em->flush();

        return $this->redirectToRoute('admin');

    }

   /* public function album(int $id, UserRepository $userRepository, Request $request)
    {
        $success = null;
        if ($request->getMethod() == 'POST' && isset($_POST['username'])) {
            $em = $this->getDoctrine()->getManager();
            $edit = $em->getRepository(User::class)->find($id);
            if (!$edit) {
                throw $this->createNotFoundException('User not found');
            }
            $edit->setUsername($_POST['username']);
            $edit->setEmail($_POST['email']);
            $userRepository->upgradePassword($edit, $_POST['password']);
            $em->persist($edit);
            $em->flush();
            $success = 'User successfully updated';
        }

        $user = $userRepository->find($id);
        return $this->render('views/admin_edit.html.twig', [
            'controller_name' => 'user edit',
            'user' => $user,
            'success' => $success
        ]);
    }*/
}
