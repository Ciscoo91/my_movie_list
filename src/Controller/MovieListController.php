<?php

namespace App\Controller;

use App\Entity\MovieList;
use App\Form\MovieListType;
use App\Service\MovieDatabaseService;
use App\Repository\MovieListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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


    /**
     * @Route("/movies/", name="app_search_movies")
     */
    public function handleMovieRequest(Request $request, MovieDatabaseService $service): Response
    {

        $searchCriteria = $request->request->get("search_criteria");
        $searchValue = $request->request->get("search_movie");
        // dump($request->request);
        switch ($searchCriteria) {
            case 'name':
                $movies = $service->getMoviesByName($searchValue);
                break;
            case 'actor':
                $data= $service->getMoviesByActor($searchValue)["results"][0]["known_for"];
                $movies = [];
                for($i = 0; $i < count($data); $i++){
                    $movies[] = $data[$i];
                }
                break;
            case 'type':
                $movies = $service->getMoviesByGenre($searchValue);
                break;
            case 'release_date':
                $movies = $service->getMoviesByReleaseDate($searchValue);
                break;
            default:
                break;
        }
        dump($request);
        
        return $this->json($movies, 200);
        // return $this->render('/movie/_movies_card.html.twig', [
        //     'movies' => $movies
        // ]);
    }

}
