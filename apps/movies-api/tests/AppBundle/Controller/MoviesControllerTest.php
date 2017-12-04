<?php

namespace ApiCycle\ApiMovies\Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class MoviesControllerTest extends BaseController
{
    public function testGetMovies()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies');
        $response = $client->getResponse();

        $expectedData = [
            'total' => 30,
            'count' => 3,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Star Wars: Empire strikes back',
                ],
                [
                    'id' => 2,
                    'name' => 'Fast and Furious 8',
                ],
                [
                    'id' => 3,
                    'name' => 'Taken 3',
                ],
            ],
        ];

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertJsonContent($response, $expectedData);
    }

    public function testGetMoviesWithBadInput()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies?order=bad');
        $response1 = $client->getResponse();

        $expectedData1 = [
            'error' => 'Bad query',
            'message' => 'Only allowed value for order is \'name\'',
        ];

        $this->assertJsonResponse($response1, Response::HTTP_BAD_REQUEST);
        $this->assertJsonContent($response1, $expectedData1);

        $crawler = $client->request('GET', '/v1/movies?order=name&dir=a');
        $response2 = $client->getResponse();

        $expectedData2 = [
            'error' => 'Bad query',
            'message' => 'Dir must be one of those: asc, desc',
        ];

        $this->assertJsonResponse($response2, Response::HTTP_BAD_REQUEST);
        $this->assertJsonContent($response2, $expectedData2);
    }

    public function testGetMoviesWithOrderAndDirection()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies?order=name&dir=desc');
        $response = $client->getResponse();

        $expectedData = [
            'total' => 30,
            'count' => 3,
            'data' => [
                [
                    'id' => 3,
                    'name' => 'Taken 3',
                ],
                [
                    'id' => 1,
                    'name' => 'Star Wars: Empire strikes back',
                ],
                [
                    'id' => 2,
                    'name' => 'Fast and Furious 8',
                ],
            ],
        ];

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertJsonContent($response, $expectedData);
    }

    public function testGetMoviesWithPagination()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies?page=3');
        $response = $client->getResponse();

        $expectedData = [
            'total' => 30,
            'count' => 3,
            'data' => [
                [
                    'id' => 7,
                    'name' => 'Another great movie 4',
                ],
                [
                    'id' => 8,
                    'name' => 'Another great movie 5',
                ],
                [
                    'id' => 9,
                    'name' => 'Another great movie 6',
                ],
            ],
        ];

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertJsonContent($response, $expectedData);
    }

    public function testRegisterMovie()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/v1/movies', ['name' => 'Nemo']);
        $response1 = $client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response1->getStatusCode());

        $crawler = $client->request('GET', '/v1/movies?order=name&dir=desc');
        $response2 = $client->getResponse();

        $expectedData = [
            'total' => 31,
            'count' => 3,
            'data' => [
                [
                    'id' => 3,
                    'name' => 'Taken 3',
                ],
                [
                    'id' => 1,
                    'name' => 'Star Wars: Empire strikes back',
                ],
                [
                    'id' => 31,
                    'name' => 'Nemo',
                ],
            ],
        ];

        $this->assertJsonContent($response2, $expectedData);
    }

    public function testRegisterMovieWithoutName()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/v1/movies');
        $response1 = $client->getResponse();

        $expectedData1 = [
            'error' => 'Bad query',
            'message' => 'name : This value should not be blank.',
        ];

        $this->assertJsonResponse($response1, Response::HTTP_BAD_REQUEST);
        $this->assertJsonContent($response1, $expectedData1);
    }

    public function testRegisterMovieTwice()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/v1/movies', ['name' => 'Nemo']);
        $crawler = $client->request('POST', '/v1/movies', ['name' => 'Nemo']);
        $response1 = $client->getResponse();

        $expectedData1 = [
            'error' => 'Bad query',
            'message' => 'name : This value is already used.',
        ];

        $this->assertJsonResponse($response1, Response::HTTP_BAD_REQUEST);
        $this->assertJsonContent($response1, $expectedData1);
    }

    public function testDeleteMovie()
    {
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/v1/movies/3');
        $response1 = $client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response1->getStatusCode());

        $crawler = $client->request('GET', '/v1/movies');
        $response2 = $client->getResponse();

        $expectedData = [
            'total' => 29,
            'count' => 3,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Star Wars: Empire strikes back',
                ],
                [
                    'id' => 2,
                    'name' => 'Fast and Furious 8',
                ],
                [
                    'id' => 4,
                    'name' => 'Another great movie 1',
                ],
            ],
        ];

        $this->assertJsonContent($response2, $expectedData);
    }
}
