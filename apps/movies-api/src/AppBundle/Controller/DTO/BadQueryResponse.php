<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller\DTO;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

/**
 * @Serializer\ExclusionPolicy("all")
 *
 * @SWG\Definition()
 */
class BadQueryResponse extends BadResponse
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Expose
     *
     * @SWG\Property()
     */
    public $message;

    /**
     * @param string $error
     * @param string $message
     */
    public function __construct($error, $message)
    {
        parent::__construct($error);

        $this->message = $message;
    }
}
