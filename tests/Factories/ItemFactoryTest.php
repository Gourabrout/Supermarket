<?php

use PHPUnit\Framework\TestCase;
use Supermarket\Item\Item;
use Supermarket\Factories\ItemFactory;
use Supermarket\Item\ItemWithSpecialPrice;

class ItemFactoryTest extends TestCase 
{
    private $itemFactory;
    public function __construct()
    {
        parent::__construct();
        $this->itemFactory = new ItemFactory;
    }

    public function testGetInstanceWithItem() {
        $data = [
            'name'  => 'B',
            'price' => 20,
        ];

        $item = $this->itemFactory->getInstance(ItemFactory::ITEM, $data);
        $this->assertTrue($item instanceof Item);
    }

    public function testGetInstanceWithItemWithSpecialPrice() {
        $data = [
            'name'  => 'C',
            'price' => 15,
        ];

        $item = $this->itemFactory->getInstance(ItemFactory::ITEM_WITH_SPECIAL_PRICE, $data);
        $this->assertTrue($item instanceof ItemWithSpecialPrice);

        $data = [
            'name'  => 'A',
            'price' => 25,
            'specialOffer' => [
                '2-48',
                '4-90',
            ]
        ];

        $item = $this->itemFactory->getInstance(ItemFactory::ITEM_WITH_SPECIAL_PRICE, $data);
        $this->assertTrue($item instanceof ItemWithSpecialPrice);
    }

    public function testGetInstanceWithItemWithCombineSpecialPrice() {
        $data = [
            'name'  => 'A',
            'price' => 25,
            'specialOffer' => [
                '2-48',
                '4-90',
                'B-10',
            ]
        ];

        $item = $this->itemFactory->getInstance(ItemFactory::ITEM_WITH_SPECIAL_PRICE, $data);
        $this->assertTrue($item instanceof ItemWithSpecialPrice);
    }

    public function testGetInstanceWithIncorrectItemType() {
        $message = '';
        $data = [
            'name'  => 'B',
            'price' => 20,
        ];

        try {
            $this->itemFactory->getInstance("Test Type!", $data);
        } catch (\Throwable $th) {
            $message = $th->getMessage();
        }

        $this->assertEquals($message , 'Test Type! Item Type Not Found.');
    }
}