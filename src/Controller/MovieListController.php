<?php

namespace App\Controller;

use App\Entity\MovieList;
use App\Form\MovieListType;
use App\Repository\MovieListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieListController extends AbstractController
{
    /**
     * @Route("/movie/list", name="app_movies")
     * @Route("/movie/list/edit/{id}", name="app_movies_edit", methods={"PUT"})
     */
    public function form(MovieList $movie = null, Request $request, EntityManagerInterface $em)
    {
        if($movie == null)
        {
            $movie = new MovieList();
        }

        $form = $this->createForm(MovieListType::class, $movie);
        $form->handleRequest($request);

        $user = $this->getUser();
        
        if($form->isSubmitted() && $form->isValid())
        {
            $movie->setUser($user);
            $em->persist($movie);
            $em->fulsh();
        }

        return $this->render('movie_list/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("movie/list/delete/{id}", name="app_delete_movielist")
     */
    public function delete(MovieList $movie, MovieListRepository $repo)
    {
        $repo->FindByIdAndDelete($movie);
        return $this->redirectToRoute("app_profile");
    }
}
