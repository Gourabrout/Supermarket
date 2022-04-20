<?php

namespace Supermarket\Item;

use Supermarket\Core\ItemInterface;

class Item implements ItemInterface
{
    protected $name;
    protected $price;

    /**
     * __construct function
     *
     * @param string $name
     * @param integer $price
     */
    public function __construct(string $name, int $price) {
        $this->name  = $name;
        $this->price = $price;
    }

    /**
     * calculatePrice function
     *
     * @param integer $itemCount
     * @param array $orderItems
     *
     * @return int
     */
    public function calculatePrice(int $itemCount, array $orderItems) {
        return $itemCount * $this->price;
    }
}
