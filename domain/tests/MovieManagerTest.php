<?php

namespace ApiCycle\Domain\Tests;

use ApiCycle\Domain\Movie;
use ApiCycle\Domain\MoviesManager;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class MovieManagerTest extends PHPUnit_Framework_TestCase
{
    use TestUtils;

    public function testConstruct()
    {
        $managerRegistryMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $validatorMock = $this->getBasicMock('\Symfony\Component\Validator\Validator\ValidatorInterface');

        $manager = new MoviesManager($managerRegistryMock, $validatorMock);
    }

    public function testRegisterMovie()
    {
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $validatorMock = $this->getBasicMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $doctrineMock->method('getManager')
            ->willReturn($entityManagerMock);
        $validatorMock->method('validate')
            ->willReturn([]);

        $manager = new MoviesManager($doctrineMock, $validatorMock);


        $entityManagerMock->expects($this->once())
            ->method('persist');
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $manager->registerMovie('Spiderman');
    }

    public function testRegisterMovieWithViolations()
    {
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $validatorMock = $this->getBasicMock('\Symfony\Component\Validator\Validator\ValidatorInterface');

        $violationsList = new ConstraintViolationList();
        $violationsList->add(new ConstraintViolation(
            'Violation 1',
            'Full violation 1',
            [],
            'A',
            'foo',
            'A'
        ));

        $validatorMock->method('validate')
            ->willReturn($violationsList);

        $manager = new MoviesManager($doctrineMock, $validatorMock);

        $this->expectException('InvalidArgumentException');
        $manager->registerMovie('Spiderman');
    }

    public function testDeleteMovie()
    {
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $validatorMock = $this->getBasicMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');
        $movieMock = $this->getBasicMock('\ApiCycle\Domain\Movie');

        $doctrineMock->method('getManager')
            ->willReturn($entityManagerMock);
        $movieMock->method('getStatus')
            ->willReturn(Movie::STATUS_VALID);

        $manager = new MoviesManager($doctrineMock, $validatorMock);

        $movieMock->expects($this->once())
            ->method('delete');
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $manager->deleteMovie($movieMock);
    }

    public function testDeleteMovieAlreadyDeleted()
    {
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $validatorMock = $this->getBasicMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');
        $movieMock = $this->getBasicMock('\ApiCycle\Domain\Movie');

        $doctrineMock->method('getManager')
            ->willReturn($entityManagerMock);
        $movieMock->method('getStatus')
            ->willReturn(Movie::STATUS_DELETED);

        $manager = new MoviesManager($doctrineMock, $validatorMock);

        $this->expectException('InvalidArgumentException');
        $manager->deleteMovie($movieMock);
    }
}