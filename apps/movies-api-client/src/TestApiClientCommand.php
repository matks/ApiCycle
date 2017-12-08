<?php

namespace ApiCycle\ApiMoviesTest;

use ApiCycle\Generated\ApiMoviesClient\Model\MoviesBody;
use ApiCycle\Generated\ApiMoviesClient\Resource\DefaultResource;
use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestApiClientCommand extends Command
{
    protected function configure()
    {
        $this->setName('check-api-client')
            ->setDescription('Perform an HTTP request to check Api Client works');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();

        /** @var DefaultResource $resource */
        $resource = $app['app.api.api-client'];

        $response = $resource->getMovies();

        // var_dump($response);

        /*
        $body = new MoviesBody();
        $body->setName('A new movie 2');

        $response = $resource->createMovie($body);
        */

        //$response = $resource->deleteMovie(27);

        var_dump($response);
    }
}