<?php

namespace ApiCycle\ApiMovies\Tests\AppBundle\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use JMS\Serializer\SerializerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends WebTestCase implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    public function setUp()
    {
        self::bootKernel();
        $this->setContainer(self::$kernel->getContainer());

        parent::setup();
        $fixtures = array(
            'ApiCycle\ApiMovies\AppBundle\DataFixtures\ORM\LoadMovieData',
        );

        $this->loadFixtures($fixtures, null, 'doctrine', ORMPurger::PURGE_MODE_TRUNCATE);
    }

    /**
     * @param Response $response
     * @param string   $status
     */
    protected function assertJsonResponse(Response $response, $status)
    {
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($status, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertIsValidJson($content);
    }

    /**
     * @param Response $response
     * @param array    $expectedData
     */
    protected function assertJsonContent(Response $response, array $expectedData)
    {
        $realData = $response->getContent();
        $realData = str_replace('\u0027', "'", $realData);

        $this->assertEquals($this->serialize($expectedData), $realData);
    }

    /**
     * @param string $json
     *
     * @return bool
     */
    protected function assertIsValidJson($json)
    {
        $data = json_decode($json);

        return null !== $data;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function serialize(array $data)
    {
        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($data, 'json');

        return $json;
    }
}
