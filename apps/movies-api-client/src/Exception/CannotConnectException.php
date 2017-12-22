<?php

namespace ApiCycle\ApiMoviesTest\Exception;

class CannotConnectException extends \Exception
{
    public function __construct($code = 0, \Exception $previous = null)
    {
        $message = 'Could not connect to API. If running these tests in dev, did you launch the web server ?';

        parent::__construct($message, $code, $previous);
    }
}
