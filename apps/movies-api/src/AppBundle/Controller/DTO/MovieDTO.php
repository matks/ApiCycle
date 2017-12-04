<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller\DTO;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class MovieDTO
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    public $name;
}