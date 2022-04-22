<?php

use PHPUnit\Framework\TestCase;
use Supermarket\Item\ItemWithSpecialPrice;

class ItemWithSpecialPriceTest extends TestCase 
{
    public function testCalculatePrice() {
        $orders = ['A'=>5, 'B' => 4, 'C' => 8];
        $item = new ItemWithSpecialPrice('B', 5);
        $price = $item->calculatePrice(4, $orders);
        $this->assertEquals(20, $price);

        $item = new ItemWithSpecialPrice('A', 15);
        $item->setSpecialPrice(2, 26);
        $price = $item->calculatePrice(5, $orders);
        $this->assertEquals(67, $price);

        $item = new ItemWithSpecialPrice('C', 20);
        $item->setSpecialPrice(2, 35);
        $item->setSpecialPrice(3, 50);
        $price = $item->calculatePrice(8, $orders);
        $this->assertEquals(135, $price);

        $item = new ItemWithSpecialPrice('C', 20);
        $item->setSpecialPrice(2, 35);
        $item->setCombineSpecialPrice('B', 10);
        $price = $item->calculatePrice(8, $orders);
        $this->assertEquals(110, $price);
    }
}