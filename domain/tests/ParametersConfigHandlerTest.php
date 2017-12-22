<?php

namespace ApiCycle\Domain\Tests;

use ApiCycle\Domain\ParametersConfigHandler;
use PHPUnit_Framework_TestCase;

class ParametersConfigHandlerTest extends PHPUnit_Framework_TestCase
{
    use TestUtils;

    public function testReplace()
    {
        $configuration = '
        a: %foo%
        b: %foo%
        c: %bar%
        ';

        $parameters = [
            'foo' => 'arg1',
            'bar' => 'arg2',
        ];

        $output = ParametersConfigHandler::replaceParametersInConfig($parameters, $configuration);

        $expected = '
        a: arg1
        b: arg1
        c: arg2
        ';

        $this->assertEquals($expected, $output);
    }
}
