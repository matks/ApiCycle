<?php

namespace ApiCycle\Domain\Tests;

use ApiCycle\Domain\PaginatedCollection;
use PHPUnit_Framework_TestCase;

class PaginatedCollectionTest extends PHPUnit_Framework_TestCase
{
    use TestUtils;

    public function testConstruct()
    {
        $items = [1, 2, 3];

        $collection = new PaginatedCollection($items, 50);

        $this->assertEquals($collection->items, $items);
        $this->assertEquals($collection->total, 50);
        $this->assertEquals($collection->count, 3);
    }

}
