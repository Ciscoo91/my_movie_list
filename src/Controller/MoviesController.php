<?php

namespace App\Controller;

use App\Service\MovieDatabaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController {


    private $movieService;

    public function __construct(MovieDatabaseService $movieService)
    {
        $this->movieService = $movieService;
    }

    /** 
     * @Route("/movie/details/{id)")
     */
    public function getMovieById($id, Request $request)
    {
        dd($request);
        $movie = $this->movieService->getMovieById($id);
        dump($movie);
        return $this->render('movie/index.html.twig', [
            'movie' => $movie
        ]);
    }

    /**
     * @Route("/movies/name/{name}")
     */
    public function getMovieByName($name)
    {
        dump($this->movieService->getMoviesByName($name));

        return $this->render('movie/index.html.twig',['movies' => $this->movieService->getMoviesByName($name)]);
    }

    /**
     * @Route("/movies/type/{type}")
     */
    public function getMoviesByType($type)
    {
        return $this->render('movie/index.html.twig', ['movies'=>$this->movieService->getMoviesByGenre($type)]);
    }

    /**
     * @Route("/movies/actor/{actor}")
     */
    public function getMoviesByActor($actor)
    {
        return $this->json($this->movieService->getMoviesByActor($actor));
    }

    /**
     * @Route("/movies/date/{date}")
     */
    public function getMoviesByReleaseDate($date)
    {
        return $this->json($this->movieService->getMoviesByReleaseDate($date));
    }
}