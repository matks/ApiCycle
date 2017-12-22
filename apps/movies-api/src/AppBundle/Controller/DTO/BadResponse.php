<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller\DTO;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

/**
 * @Serializer\ExclusionPolicy("all")
 *
 * @SWG\Definition()
 */
class BadResponse
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     *
     * @SWG\Property()
     */
    public $error;

    /**
     * @param string $error
     */
    public function __construct($error)
    {
        $this->error = $error;
    }
}
