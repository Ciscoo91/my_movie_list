<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class MovieDatabaseService {

    private $client;
    private $apikey;

    public function __construct($apiKey, HttpClientInterface $client)
    {
        $this->client = $client;
        $this->apikey = $apiKey;
    }
    /**
     * @Get Movies by Name
     */
    public function getMoviesByName($name)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/movie?api_key='.$this->apikey.'&language=en-US&page=1&include_adult=false&query='.$name.''
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    /**
     * @Get top rated movies
     */
    public function getTopRatedMovies()
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/popular?api_key='.$this->apikey.'&language=en-US&page=1'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        $movies = [];

        for($i = 0; $i < 3; $i++)
        {
            $movies[] = $content["results"][$i];
        }
        return $movies;

    }

    public function getMovieGenres()
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/genre/movie/list?api_key='.$this->apikey.'&language=en-US'
        );

        $statusCode = $response->getStatusCode();
        $contentTYpe = $response->getHeaders()["content-type"][0];
        $content = $response->toArray();

        return $content;
    }

    public function getMoviesByGenre($genre)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/discover/movie?api_key=$'.$this->apikey.'&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres='.$genre.''
        );
    }

    public function getMovieDetailsById($id)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$this->apikey.'&language=en-US'
        );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()["content-type"][0];
        $content = $response->toArray();

        return $content;
    }

    public function getMoviesByActor($actor)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/search/person?api_key='.$this->apikey.'&language=en-US&query='.$actor.'&page=1&include_adult=false'
        );

        $statusCode = $response->getStatusCode();
        $contentTYpe = $response->getHeaders()["content-type"][0];
        $content = $response->toArray();

        return $content;
    }


    public function getMoviesByReleaseDate($date)
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/discover/movie?api_key=9b64022f9a7fd27a896f39bb9852567f&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&year='.$date
        );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()["content-type"];
        $content = $response->toArray();

        return $content;
    }
}