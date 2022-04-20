<?php

namespace Supermarket\Core;

interface ItemInterface
{
    /**
     * __construct function
     *
     * @param string $name
     * @param integer $price
     */
    public function __construct(string $name, int $price);

    /**
     * calculatePrice function
     *
     * @param integer $itemCount
     * @param array $orderItems
     *
     * @return int
     */
    public function calculatePrice(int $itemCount, array $orderItems);
}
