<?php

namespace ApiCycle\ApiMoviesTest;

use ApiCycle\Generated\ApiMoviesClient\Resource\DefaultResource;
use Knp\Command\Command;
use ApiCycle\Generated\ApiMoviesClient\Resource\V1MoviesResource;
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

        $response = $resource->getV1Movies();

        var_dump((string)$response->getBody());
    }
}