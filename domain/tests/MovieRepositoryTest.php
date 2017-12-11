<?php

namespace ApiCycle\Domain\Tests;

use ApiCycle\Domain\MovieRepository;
use PHPUnit_Framework_TestCase;

class MovieRepositoryTest extends PHPUnit_Framework_TestCase
{
    use TestUtils;

    public function testConstruct()
    {
        $classMetadataMock = $this->getBasicMock('\Doctrine\ORM\Mapping\ClassMetadata');
        $entityManagerMock = $this->getBasicMock('\Doctrine\ORM\EntityManager');

        $movieRepository = new MovieRepository($entityManagerMock, $classMetadataMock);

        $this->assertInstanceOf('\Doctrine\ORM\EntityRepository', $movieRepository);
    }
}
