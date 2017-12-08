<?php

namespace ApiCycle\Generated\ApiMoviesClient\Model;

class MoviesViewDTO
{
    /**
     * @var int
     */
    protected $total;
    /**
     * @var int
     */
    protected $count;
    /**
     * @var mixed[]
     */
    protected $data;
    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
    /**
     * @param int $total
     *
     * @return self
     */
    public function setTotal($total = null)
    {
        $this->total = $total;
        return $this;
    }
    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
    /**
     * @param int $count
     *
     * @return self
     */
    public function setCount($count = null)
    {
        $this->count = $count;
        return $this;
    }
    /**
     * @return mixed[]
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @param mixed[] $data
     *
     * @return self
     */
    public function setData(array $data = null)
    {
        $this->data = $data;
        return $this;
    }
}