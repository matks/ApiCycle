<?php

namespace ApiCycle\Generated\ApiMoviesClient\Model;

class BadResponse
{
    /**
     * @var string
     */
    protected $error;
    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
    /**
     * @param string $error
     *
     * @return self
     */
    public function setError($error = null)
    {
        $this->error = $error;
        return $this;
    }
}