<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller\DTO;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

/**
 * @Serializer\ExclusionPolicy("all")
 *
 * @SWG\Definition()
 */
class SuccessResponse
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     *
     * @SWG\Property()
     */
    public $status = 'success';
}