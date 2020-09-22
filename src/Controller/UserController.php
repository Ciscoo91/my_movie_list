<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/{id}/delete", name="app_user_unsubscribe")
     */
    public function deleteUser(User $user, UserRepository $repo)
    {
        $repo->findByIdAndDelete($user);
        return $this->redirectToRoute("app_home");
    }
}
