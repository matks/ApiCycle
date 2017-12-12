<?php

namespace ApiCycle\Generated\ApiMoviesClient\Resource;

use Joli\Jane\OpenApi\Runtime\Client\QueryParam;
use Joli\Jane\OpenApi\Runtime\Client\Resource;
class DefaultResource extends Resource
{
    /**
     * Get movies
     *
     * @param array  $parameters {
     *     @var string $order Order criterion
     *     @var string $dir Sort criterion
     *     @var int $page Page number
     * }
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO
     */
    public function getMovies($parameters = array(), $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $queryParam->setDefault('order', NULL);
        $queryParam->setDefault('dir', NULL);
        $queryParam->setDefault('page', NULL);
        $url = '/v1/movies';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(array('Host' => 'localhost', 'Accept' => array('application/json')), $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('GET', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'ApiCycle\\Generated\\ApiMoviesClient\\Model\\MoviesViewDTO', 'json');
            }
        }
        return $response;
    }
    /**
     * Create a movie
     *
     * @param \ApiCycle\Generated\ApiMoviesClient\Model\MoviesPostBody $data 
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|\ApiCycle\Generated\ApiMoviesClient\Model\SuccessResponse|\ApiCycle\Generated\ApiMoviesClient\Model\BadQueryResponse
     */
    public function createMovie(\ApiCycle\Generated\ApiMoviesClient\Model\MoviesPostBody $data, $parameters = array(), $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/v1/movies';
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(array('Host' => 'localhost', 'Accept' => array('application/json'), 'Content-Type' => 'application/json'), $queryParam->buildHeaders($parameters));
        $body = $this->serializer->serialize($data, 'json');
        $request = $this->messageFactory->createRequest('POST', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('200' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'ApiCycle\\Generated\\ApiMoviesClient\\Model\\SuccessResponse', 'json');
            }
            if ('400' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'ApiCycle\\Generated\\ApiMoviesClient\\Model\\BadQueryResponse', 'json');
            }
        }
        return $response;
    }
    /**
     * Delete a movie
     *
     * @param int $id 
     * @param array  $parameters List of parameters
     * @param string $fetch      Fetch mode (object or response)
     *
     * @return \Psr\Http\Message\ResponseInterface|null|\ApiCycle\Generated\ApiMoviesClient\Model\BadQueryResponse
     */
    public function deleteMovie($id, $parameters = array(), $fetch = self::FETCH_OBJECT)
    {
        $queryParam = new QueryParam();
        $url = '/v1/movies/{id}';
        $url = str_replace('{id}', urlencode($id), $url);
        $url = $url . ('?' . $queryParam->buildQueryString($parameters));
        $headers = array_merge(array('Host' => 'localhost', 'Accept' => array('application/json')), $queryParam->buildHeaders($parameters));
        $body = $queryParam->buildFormDataString($parameters);
        $request = $this->messageFactory->createRequest('DELETE', $url, $headers, $body);
        $promise = $this->httpClient->sendAsyncRequest($request);
        if (self::FETCH_PROMISE === $fetch) {
            return $promise;
        }
        $response = $promise->wait();
        if (self::FETCH_OBJECT == $fetch) {
            if ('204' == $response->getStatusCode()) {
                return null;
            }
            if ('400' == $response->getStatusCode()) {
                return $this->serializer->deserialize((string) $response->getBody(), 'ApiCycle\\Generated\\ApiMoviesClient\\Model\\BadQueryResponse', 'json');
            }
        }
        return $response;
    }
}