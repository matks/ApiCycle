<?php

namespace ApiCycle\Domain;

/**
 * @see https://knpuniversity.com/screencast/symfony-rest3/pagerfanta-pagination
 */
class PaginatedCollection
{
    /** @var array */
    public $items;

    /** @var int */
    public $total;

    /** @var int */
    public $count;

    /**
     * @param array|\Traversable $items
     * @param int                $total
     */
    public function __construct($items, $total)
    {
        if ($items instanceof \Traversable) {
            foreach ($items as $item) {
                $this->items[] = $item;
            }
        } else {
            $this->items = $items;
        }

        $this->total = $total;
        $this->count = count($items);
    }
}
