<?php

namespace ApiCycle\Generated\ApiMoviesClient\Model;

class BadQueryResponse
{
    /**
     * @var string
     */
    protected $message;
    /**
     * @var string
     */
    protected $error;
    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage($message = null)
    {
        $this->message = $message;
        return $this;
    }
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