<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller;

use ApiCycle\Domain\MoviesManager;
use ApiCycle\Domain\Movie;
use ApiCycle\Domain\MovieRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MoviesController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function getMoviesAction(Request $request)
    {
        $order = $request->get('order');
        $dir = $request->get('dir');
        $page = $request->query->get('page', 1);

        $movieRepository = $this->getMoviesRepository();
        $moviesPage = $movieRepository->getMovies($page, $order, $dir);

        $context = new Context();
        $context->setGroups(['movie']);

        $view = $this->view($moviesPage);
        $view->setContext($context);

        return $view;
    }

    public function postMovieAction(Request $request)
    {
        $name = $request->get('name');

        $movie = $this->getMoviesManager()->registerMovie($name);

        return new JsonResponse('ok', Response::HTTP_OK);
    }

    /**
     * @param int $movieId
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function deleteMovieAction($movieId)
    {
        $movieRepository = $this->getMoviesRepository();
        $manager = $this->getMoviesManager();

        /** @var Movie $movie */
        $movie = $movieRepository->findOneById($movieId);

        $result = $manager->deleteMovie($movie);

        if (false === $result) {
            throw new \Exception(sprintf('Failed to delete movie %d', $movieId));
        }

        return new JsonResponse('ok', Response::HTTP_NO_CONTENT);
    }

    /**
     * @return MovieRepository
     */
    private function getMoviesRepository()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ApiCycle\Domain\Movie');

        return $repository;
    }

    /**
     * @return MoviesManager
     */
    private function getMoviesManager()
    {
        return $this->get('app.movies_manager');
    }
}
