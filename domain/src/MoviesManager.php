<?php

namespace ApiCycle\Domain;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MoviesManager
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ManagerRegistry    $doctrine
     * @param ValidatorInterface $validator
     */
    public function __construct(ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $this->doctrine = $doctrine;
        $this->validator = $validator;
    }

    /**
     * @param string $name
     *
     * @return Movie
     */
    public function registerMovie($name)
    {
        $movie = new Movie($name);

        $violations = $this->validator->validate($movie);

        if (0 < count($violations)) {
            $errorMessages = $this->getErrorMessagesFromViolations($violations);
            throw new \InvalidArgumentException(current($errorMessages));
        }

        $entityManager = $this->doctrine->getManager();

        $entityManager->persist($movie);
        $entityManager->flush();

        return $movie;
    }

    /**
     * @param Movie $movie
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function deleteMovie(Movie $movie)
    {
        if (Movie::STATUS_VALID !== $movie->getStatus()) {
            throw new \InvalidArgumentException(sprintf(
                'Movie %d cannot be deleted',
                $movie->getId()
            ));
        }

        $movie->delete();

        $entityManager = $this->doctrine->getManager();
        $entityManager->flush($movie);

        return true;
    }

    /**
     * @param ConstraintViolationListInterface $list
     *
     * @return string[]
     */
    private function getErrorMessagesFromViolations(ConstraintViolationListInterface $list)
    {
        $errorMessages = [];

        foreach ($list as $violation) {
            $errorMessages[] = $violation->getPropertyPath().' : '.$violation->getMessage();
        }

        return $errorMessages;
    }
}
