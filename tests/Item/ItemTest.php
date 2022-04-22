<?php

use PHPUnit\Framework\TestCase;
use Supermarket\Item\Item;

class ItemTest extends TestCase 
{
    public function testCalculatePrice() {
        $item = new Item('B', 10);
        $price = $item->calculatePrice(4, ['B' => 4, 'C' => 2]);
        $this->assertEquals(40, $price);
    }
}