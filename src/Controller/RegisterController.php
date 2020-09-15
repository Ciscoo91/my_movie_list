<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @Route("/user/{id}/edit", name="app_user_edit")
     */
    public function form(User $user = null, Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $password_encoder)
    {
        // dd($user);
        if(!$user)
        {
            $user = new User();
        }

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   
        
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setPassword($password_encoder->encodePassword($user, $form->get('password')->getData()));
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'editMode' => $user->getId() !== null
        ]);
    }
}
