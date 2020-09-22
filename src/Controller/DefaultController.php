<?php

namespace App\Controller;

use App\Service\MovieDatabaseService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(MovieDatabaseService $movieService)
    {

        $movies = $movieService->getTopRatedMovies();

        return $this->render('default/index.html.twig', [
            'movies' => $movies,
        ]);
    }

}
