<?php

use PHPUnit\Framework\TestCase;
use Supermarket\Item\Item;
use Supermarket\Factories\ItemFactory;
use Supermarket\Item\ItemWithSpecialPrice;
use Supermarket\Controllers\SupermarketController;

class SupermarketControllerTest extends TestCase 
{
    public function testSetOrderAndGetOrder() {
        $itemFactoryStub = $this->createMock(ItemFactory::class);
        $supermarket = new SupermarketController($itemFactoryStub);
        $supermarket->setOrder(['B', 'B', 'A', 'C']);
        $order = $supermarket->getOrder();

        $this->assertEquals($order, ['B' => 2, 'A' => 1, 'C' =>1]);
    }

    public function testSetItemsAndGetItemsWithItem() {
        $itemFactoryStub = $this->createMock(ItemFactory::class);
        $itemFactoryStub->method('getInstance')->willReturn(new Item('A', 5));

        $supermarket = new SupermarketController($itemFactoryStub);
        $supermarket->setItems([
            ['A', 5],
        ]);

        $items = $supermarket->getItems();
        $this->assertEquals(count($items), 1);
        $this->assertTrue($items['A'] instanceof Item);
    }

    public function testSetItemsAndGetItemsWithItemWithSpecialPrice() {
        $itemFactoryStub = $this->createMock(ItemFactory::class);
        $item = new ItemWithSpecialPrice('A', 15);
        $item->setSpecialPrice(2, 25);
        $itemFactoryStub->method('getInstance')->willReturn($item);

        $supermarket = new SupermarketController($itemFactoryStub);
        $supermarket->setItems([
            ['A', 15, '2-25'],
        ]);

        $items = $supermarket->getItems();
        $this->assertEquals(count($items), 1);
        $this->assertTrue($items['A'] instanceof ItemWithSpecialPrice);
    }

    public function testSetItemsAndGetItemsWithItemWithCombineSpecialPrice() {
        $itemFactoryStub = $this->createMock(ItemFactory::class);
        $item = new ItemWithSpecialPrice('A', 15);
        $item->setSpecialPrice(2, 25);
        $item->setCombineSpecialPrice('B', 5);
        $itemFactoryStub->method('getInstance')->willReturn($item);

        $supermarket = new SupermarketController($itemFactoryStub);
        $supermarket->setItems([
            ['A', 15, '2-25', 'B-5'],
        ]);

        $items = $supermarket->getItems();
        $this->assertEquals(count($items), 1);
        $this->assertTrue($items['A'] instanceof ItemWithSpecialPrice);
    }

    public function testCalculateTotalPrice() {
        $itemFactoryStub = $this->createMock(ItemFactory::class);
        $itemStub = $this->createMock(Item::class);

        $itemStub->method('calculatePrice')->willReturn(30);
        $itemFactoryStub->method('getInstance')->willReturn($itemStub);

        $supermarket = new SupermarketController($itemFactoryStub);
        $supermarket->setItems([
            ['A', 15],
        ]);

        $supermarket->setOrder(['A', 'A']);
        $price = $supermarket->calculateTotalPrice();
        $this->assertEquals($price, 30);
    }

    public function testCalculateTotalPriceWithSpecialItem() {
        $itemFactoryStub = $this->createMock(ItemFactory::class);
        $item = new ItemWithSpecialPrice('A', 15);
        $item->setSpecialPrice(2, 25);
        $item->setCombineSpecialPrice('B', 5);
        $itemFactoryStub->method('getInstance')->willReturn($item);

        $supermarket = new SupermarketController($itemFactoryStub);
        $supermarket->setItems([
            ['A', 15, '2-25', 'B-5'],
        ]);

        $supermarket->setOrder(['A', 'A']);
        $price = $supermarket->calculateTotalPrice();
        $this->assertEquals($price, 25);

        $supermarket->setOrder(['A', 'A', 'A']);
        $price = $supermarket->calculateTotalPrice();
        $this->assertEquals($price, 40);
    }
}