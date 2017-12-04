<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller\DTO;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class SuccessResponse
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    public $status = 'success';
}