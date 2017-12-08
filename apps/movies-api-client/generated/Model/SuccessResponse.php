<?php

namespace ApiCycle\Generated\ApiMoviesClient\Model;

class SuccessResponse
{
    /**
     * @var string
     */
    protected $status;
    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus($status = null)
    {
        $this->status = $status;
        return $this;
    }
}