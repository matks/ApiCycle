<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ApiCycle\Generated\ApiMoviesClient\Normalizer\NormalizerFactory;
use ApiCycle\Generated\ApiMoviesClient\Resource\DefaultResource;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Joli\Jane\Runtime\Encoder\RawEncoder;
use Knp\Provider\ConsoleServiceProvider;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

$app = new Silex\Application();

/**
 * @param string $paramFilepath
 * @param string $configFilepath
 *
 * @return array
 */
function parseConfiguration($paramFilepath, $configFilepath)
{
    $parameters = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($paramFilepath));
    $configAsAString = file_get_contents($configFilepath);
    $configAsAString = \ApiCycle\Domain\ParametersConfigHandler::replaceParametersInConfig(
        $parameters['parameters'],
        $configAsAString
    );

    $configuration = \Symfony\Component\Yaml\Yaml::parse($configAsAString);

    return $configuration;
}

$paramFilepath = realpath(__DIR__ . '/parameters.yml');
$configFilepath = realpath(__DIR__ . '/config.yml');
$configuration = parseConfiguration($paramFilepath, $configFilepath);

$parameters = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($paramFilepath));
if (isset($parameters['parameters']['environment']) && ('dev' === $parameters['parameters']['environment'])) {
    $app['debug'] = true;
}

/* Dependency Injection */

$app['app.api.http-client'] = function ($app) use ($configuration) {
    $httpClient = new GuzzleAdapter(new GuzzleClient([
        'base_uri' => $configuration['api_client']['api_host']
    ]));

    return $httpClient;
};

$app['app.api.request-factory'] = function ($app) use ($configuration) {
    $requestFactory = new GuzzleMessageFactory();

    return $requestFactory;
};

$app['app.api.serializer'] = function ($app) use ($configuration) {
    $serializer = new Serializer(
        NormalizerFactory::create(),
        [
            new JsonEncoder(
                new JsonEncode(),
                new JsonDecode()
            ),
            new RawEncoder()
        ]
    );

    return $serializer;
};

$app['app.api.api-client'] = function ($app) use ($configuration) {
    $resource = new DefaultResource(
        $app['app.api.http-client'],
        $app['app.api.request-factory'],
        $app['app.api.serializer']
    );

    return $resource;
};

$app->register(new ConsoleServiceProvider(), array(
    'console.name' => 'ApiMoviesClientConsole',
    'console.version' => '1.0.0',
    'console.project_directory' => __DIR__ . '/..'
));

return $app;

?>