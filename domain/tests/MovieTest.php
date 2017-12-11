<?php

namespace ApiCycle\Domain\Tests;

use ApiCycle\Domain\Movie;
use PHPUnit_Framework_TestCase;

class MovieTest extends PHPUnit_Framework_TestCase
{
    use TestUtils;

    public function testConstruct()
    {
        $now = new \DateTime();
        $movie = new Movie('Spiderman');

        $this->assertEquals(Movie::STATUS_VALID, $movie->getStatus());
        $this->assertGreaterThan($now, $movie->getCreatedAt());
    }

    public function testSetName()
    {
        $movie = new Movie('Spiderman');
        $movie->setName('Spiderman 2');

        $this->assertEquals('Spiderman 2', $movie->getName());

    }

    public function testDelete()
    {
        $now = new \DateTime();
        $movie = new Movie('Spiderman');
        $movie->delete();

        $this->assertEquals(Movie::STATUS_DELETED, $movie->getStatus());
        $this->assertGreaterThan($now, $movie->getDeletedAt());
    }
}
