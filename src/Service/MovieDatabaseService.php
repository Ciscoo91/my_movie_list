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
            'https://api.themoviedb.org/3/movie/top_rated?api_key='.$this->apikey.'&language=en-US&page=1&total_results=10'
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
}