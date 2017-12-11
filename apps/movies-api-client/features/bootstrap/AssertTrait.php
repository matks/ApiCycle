<?php

use ApiCycle\ApiMoviesTest\Exception\TestIsWrongException;

trait AssertTrait
{

    /**
     * @throws TestIsWrongException
     */
    protected function assertLatestResponseIsMovieList()
    {
        if (false === ($this->latestResponse instanceof \ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO)) {
            throw new TestIsWrongException('Latest response is not a movies list');
        }
    }

    /**
     * @throws TestIsWrongException
     */
    protected function assertLatestResponseIsMoviesAPISuccessResponse()
    {
        if (false === ($this->latestResponse instanceof \ApiCycle\Generated\ApiMoviesClient\Model\SuccessResponse)) {
            $class = get_class($this->latestResponse);
            throw new TestIsWrongException(sprintf('Latest response is not a Movies API success response, it is a %s instead', $class));
        }
    }

    /**
     * @throws TestIsWrongException
     */
    protected function assertLatestResponseIsNull()
    {
        if (null !== $this->latestResponse) {
            throw new TestIsWrongException(sprintf('Latest response is not null'));
        }
    }

    /**
     * @throws TestIsWrongException
     */
    protected function assertLatestResponseIsHttpBadResponse()
    {
        if (false === ($this->latestResponse instanceof \GuzzleHttp\Psr7\Response)) {
            throw new TestIsWrongException('Latest response is not an HTTP response');
        }

        $statusCode = $this->latestResponse->getStatusCode();

        if (in_array($statusCode, self::getSuccessStatusCodes())) {
            throw new TestIsWrongException(sprintf('Latest response is not a bad HTTP response, got status code %s', $statusCode));
        }
    }

    /**
     * @param int $int1
     * @param int $int2
     * @param string $message
     *
     * @throws TestIsWrongException
     */
    protected function asserIntegerEquals($int1, $int2, $message)
    {
        if ($int1 !== $int2) {
            throw new TestIsWrongException(sprintf(
                    $message,
                    $int2,
                    $int1
                )
            );
        }
    }

    /**
     * @param string $row
     * @param array $list
     *
     * @throws TestIsWrongException
     */
    protected function assertMovieListContains($row, array $list)
    {
        foreach ($list as $movie) {
            if ($row === $movie->name) {
                return true;
            }
        }

        throw new TestIsWrongException(sprintf('List does not contain %s', $row));
    }

    /**
     * @param $row
     * @param array $list
     *
     * @throws TestIsWrongException
     */
    protected function assertMovieListDoesNotContains($row, array $list)
    {
        foreach ($list as $movie) {
            if ($row === $movie->name) {
                throw new TestIsWrongException(sprintf('List contains %s', $row));
            }
        }
    }

    /**
     * @return int[]
     */
    protected static function getSuccessStatusCodes()
    {
        return [
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            \Symfony\Component\HttpFoundation\Response::HTTP_CREATED,
            \Symfony\Component\HttpFoundation\Response::HTTP_ACCEPTED,
            \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT,
            \Symfony\Component\HttpFoundation\Response::HTTP_RESERVED,
            \Symfony\Component\HttpFoundation\Response::HTTP_PARTIAL_CONTENT,
        ];
    }
}