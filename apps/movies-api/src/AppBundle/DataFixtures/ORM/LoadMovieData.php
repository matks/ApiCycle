<?php

namespace ApiCycle\ApiMovies\AppBundle\DataFixtures\ORM;

use ApiCycle\Domain\Movie;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMovieData implements FixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $starwars = new Movie('Star Wars: Empire strikes back');
        $fast = new Movie('Fast and Furious 8');
        $taken = new Movie('Taken 3');

        $manager->persist($starwars);
        $manager->persist($fast);
        $manager->persist($taken);

        for ($i = 1; $i <= 27; ++$i) {
            $randomMovie = new Movie(sprintf('Another great movie %d', $i));
            $manager->persist($randomMovie);
        }

        $manager->flush();
    }
}
