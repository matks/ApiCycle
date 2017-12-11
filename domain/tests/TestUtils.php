<?php

namespace ApiCycle\Domain\Tests;

/**
 * Util shortcuts for tests
 */
trait TestUtils
{
    private function getBasicMock($className)
    {
        $mock = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();

        return $mock;
    }

}
