<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception\HttpException;
use ApiCycle\Generated\ApiMoviesClient\Model\MoviesPostBody;
use ApiCycle\ApiMoviesTest\Exception\CannotConnectException;

class FeatureContext implements Context
{
    use AssertTrait;

    /**
     * @var \ApiCycle\Generated\ApiMoviesClient\Resource\DefaultResource
     */
    private static $apiClient;

    /**
     * @var mixed
     */
    private $latestResponse;

    public function __construct()
    {
    }

    /**
     * @BeforeSuite
     */
    public static function prepare($scope)
    {
        $silexApp = require_once __DIR__ . '/../../app/bootstrap.php';
        self::$apiClient = $silexApp['app.api.api-client'];
    }

    /**
     * @return \ApiCycle\Generated\ApiMoviesClient\Resource\DefaultResource
     */
    public static function getApiClient()
    {
        return self::$apiClient;
    }

    /**
     * @When I fetch movies from the Api
     */
    public function fetchMoviesBasic()
    {
        try {
            $this->latestResponse = self::getApiClient()->getMovies();
        } catch (\Exception $e) {
            $this->handleExceptionsAfterAPICall($e);
        }
    }

    /**
     * @When I fetch page :page from movies from the Api using an :dir sorting on names
     */
    public function fetchMoviesAdvanced($page, $dir)
    {
        try {
            $this->latestResponse = self::getApiClient()->getMovies(['dir' => $dir, 'page' => $page, 'order' => 'name']);
        } catch (\Exception $e) {
            $this->handleExceptionsAfterAPICall($e);
        }
    }

    /**
     * @When I create a movie :name
     */
    public function createMovie($name)
    {
        $body = new MoviesPostBody();
        $body->setName($name);

        try {
            $this->latestResponse = self::getApiClient()->createMovie($body);
        } catch (\Exception $e) {
            $this->handleExceptionsAfterAPICall($e);
        }
    }

    /**
     * @When I delete the movie :id
     */
    public function deleteMovie($id)
    {
        try {
            self::getApiClient()->deleteMovie(intval($id));
            $this->latestResponse = null;
        } catch (\Exception $e) {
            $this->handleExceptionsAfterAPICall($e);
        }
    }

    /**
     * @Then I should receive a list of :int1 movies with a total of :int2
     */
    public function assertMoviesListCount($int1, $int2)
    {
        $this->assertLatestResponseIsMovieList();

        /** @var \ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO $response */
        $response = $this->latestResponse;

        $this->asserIntegerEquals(intval($int1), $response->getCount(), 'Movies list contains %d movies, not %d');
        $this->asserIntegerEquals(intval($int2), $response->getTotal(), 'Movies total is %d, not %d');
    }

    /**
     * @Then the list should contain:
     */
    public function assertMoviesListContain(TableNode $table)
    {
        $this->assertLatestResponseIsMovieList();

        /** @var \ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO $response */
        $response = $this->latestResponse;
        $list = $response->getData();

        foreach ($table as $row) {
            $movieExpectedName = $row['movie name'];

            $this->assertMovieListContains($movieExpectedName, $list);
        }
    }

    /**
     * @Then the list should NOT contain:
     */
    public function assertMoviesListDoesNotContain(TableNode $table)
    {
        $this->assertLatestResponseIsMovieList();

        /** @var \ApiCycle\Generated\ApiMoviesClient\Model\MoviesViewDTO $response */
        $response = $this->latestResponse;
        $list = $response->getData();

        foreach ($table as $row) {
            $movieExpectedName = $row['movie name'];

            $this->assertMovieListDoesNotContains($movieExpectedName, $list);
        }
    }

    /**
     * @Then I should receive a success response
     */
    public function assertSuccessResponse()
    {
        $this->assertLatestResponseIsMoviesAPISuccessResponse();
    }

    /**
     * @Then I should receive a bad response
     */
    public function assertBadResponse()
    {
        $this->assertLatestResponseIsHttpBadResponse();
    }

    /**
     * @Then I should receive a null response
     */
    public function assertNullResponse()
    {
        $this->assertLatestResponseIsNull();
    }

    /**
     * @param Exception $e
     *
     * @throws CannotConnectException
     * @throws Exception
     */
    protected function handleExceptionsAfterAPICall(\Exception $e)
    {
        if ($e instanceof NetworkException) {
            throw new CannotConnectException();
        }

        if ($e instanceof HttpException) {
            $this->latestResponse = $e->getResponse();
            return;
        }

        throw $e;
    }
}
