<?php

namespace ApiCycle\ApiMovies\AppBundle\Controller\DTO;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;

/**
 * @Serializer\ExclusionPolicy("all")
 *
 * @SWG\Definition()
 */
class MoviesViewDTO
{
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\Expose
     * @Serializer\Groups({"movie", "all"})
     *
     * @SWG\Property()
     */
    public $total;

    /**
     * @var int
     *
     * @Serializer\Type("integer")
     * @Serializer\Expose
     * @Serializer\Groups({"movie", "all"})
     *
     * @SWG\Property()
     */
    public $count;

    /**
     * @var Movie[]
     *
     * @Serializer\Type("array<ApiCycle\Domain\Movie>")
     * @Serializer\Expose
     * @Serializer\Groups({"movie", "all"})
     *
     * @SWG\Property()
     */
    public $data;

    /**
     * @param int     $total
     * @param int     $count
     * @param Movie[] $data
     */
    public function __construct($total, $count, array $data)
    {
        $this->total = $total;
        $this->count = $count;
        $this->data = $data;
    }
}
