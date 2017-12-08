<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller;

use ApiCycle\ApiMovies\AppBundle\Controller\DTO\SuccessResponse;
use ApiCycle\ApiMovies\AppBundle\Controller\DTO\EmptyResponse;
use ApiCycle\Domain\MoviesManager;
use ApiCycle\Domain\Movie;
use ApiCycle\Domain\MovieRepository;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;

class MoviesController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @return \FOS\RestBundle\View\View
     *
     * @SWG\Get(
     *     path="/movies",
     *     summary="Get movies",
     *     description="Get movies",
     *     operationId="getMovies",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="order",
     *         in="query",
     *         description="Order criterion",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="dir",
     *         in="query",
     *         description="Sort criterion",
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(ref="#/definitions/MoviesViewDTO"),
     *     )
     * )
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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @SWG\Post(
     *     path="/movies",
     *     summary="Create a movie",
     *     description="Create a movie",
     *     operationId="createMovie",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="data",
     *         in="body",
     *         required=true,
     *         type="object",
     *         @SWG\Schema(
     *             required={"name"},
     *             @SWG\Property(property="name", type="string"),
     *         ),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad query",
     *         @SWG\Schema(ref="#/definitions/BadQueryResponse"),
     *     )
     * )
     */
    public function postMovieAction(Request $request)
    {
        $name = $request->get('name');

        $movie = $this->getMoviesManager()->registerMovie($name);

        return new JsonResponse(new SuccessResponse(), Response::HTTP_OK);
    }

    /**
     * @param int $movieId
     *
     * @return JsonResponse
     *
     * @throws \Exception
     *
     * @SWG\Delete(
     *     path="/movies/{id}",
     *     summary="Delete a movie",
     *     description="Delete a movie",
     *     operationId="deleteMovie",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="Success",
     *         @SWG\Schema(ref="#/definitions/EmptyResponse"),
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad query",
     *         @SWG\Schema(ref="#/definitions/BadQueryResponse"),
     *     )
     * )
     */
    public function deleteMovieAction($movieId)
    {
        $movieRepository = $this->getMoviesRepository();
        $manager = $this->getMoviesManager();

        /** @var Movie $movie */
        $movie = $movieRepository->findOneById($movieId);

        if (null === $movie) {
            throw new \InvalidArgumentException(sprintf("Cannot find movie %d", $movieId));
        }

        $result = $manager->deleteMovie($movie);

        if (false === $result) {
            throw new \Exception(sprintf('Failed to delete movie %d', $movieId));
        }

        return new JsonResponse(new EmptyResponse(), Response::HTTP_NO_CONTENT);
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
