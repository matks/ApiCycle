<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller;

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

                $data = [
                    'error' => 'Bad query',
                    'message' => $message,
                ];

                return new JsonResponse($data, Response::HTTP_BAD_REQUEST);
                break;

            case $exception instanceof NotFoundHttpException:
                return new JsonResponse('Unknown endpoint', Response::HTTP_NOT_FOUND);

            default:
                return new JsonResponse('An error has happened', Response::HTTP_BAD_REQUEST);
        }
    }
}
