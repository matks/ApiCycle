<?php

namespace ApiCycle\ApiMovies\AppBundle\View;

use ApiCycle\ApiMovies\AppBundle\Controller\DTO\MoviesViewDTO;
use ApiCycle\Domain\PaginatedCollection;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @see https://github.com/liip/LiipHelloBundle
 */
class WithTotalViewHandler
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ViewHandler $viewHandler
     * @param View        $view
     * @param Request     $request
     * @param string      $format
     *
     * @return JsonResponse
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {
        $this->validateView($view);

        /** @var PaginatedCollection $paginatedCollection */
        $paginatedCollection = $view->getData();

        $viewDTO = new MoviesViewDTO(
            $paginatedCollection->total,
            $paginatedCollection->count,
            $paginatedCollection->items
        );

        $movieGroup = $this->getMovieSerializationGroup($view->getContext()->getGroups());
        $json = $this->serializer->serialize($viewDTO, 'json', $movieGroup);

        return new JsonResponse($json, 200, $view->getHeaders(), true);
    }

    /**
     * @param View $view
     *
     * @throws \RuntimeException
     */
    private function validateView(View $view)
    {
        $paginatedCollection = $view->getData();

        if (false === ($paginatedCollection instanceof PaginatedCollection)) {
            throw new \RuntimeException('View data must be an instance of PaginatedCollection');
        }
    }

    /**
     * @return SerializationContext
     */
    private function getMovieSerializationGroup($groups)
    {
        $context = SerializationContext::create()->setGroups($groups);

        return $context;
    }
}
