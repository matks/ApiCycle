<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller;

use ApiCycle\ApiMovies\AppBundle\Controller\DTO\BadQueryResponse;
use ApiCycle\ApiMovies\AppBundle\Controller\DTO\BadResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function handleException(Request $request)
    {
        $parameters = $request->attributes;
        $exception = $parameters->get('exception');

        switch (true) {
            case $exception instanceof \InvalidArgumentException:
                $message = $exception->getMessage();

                $responseBody = new BadQueryResponse('Bad query', $message);

                return new JsonResponse($responseBody, Response::HTTP_BAD_REQUEST);
                break;

            case $exception instanceof NotFoundHttpException:
                return new JsonResponse(new BadResponse('Unknown endpoint'), Response::HTTP_NOT_FOUND);

            default:
                return new JsonResponse(new BadResponse('An error has happened'), Response::HTTP_BAD_REQUEST);
        }
    }
}
