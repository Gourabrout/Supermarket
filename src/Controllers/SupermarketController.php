<?php

namespace Supermarket\Controllers;

use Supermarket\Factories\ItemFactory;

class SupermarketController
{
    const INDEX_OF_ITEM_NAME  = 0;
    const INDEX_OF_ITEM_PRICE = 1;

    private $order;
    private $items = [];
    private $itemFactory;

    /**
     * __construct function
     *
     * @param ItemFactory $itemFactory
     */
    public function __construct(ItemFactory $itemFactory) {
        $this->itemFactory = $itemFactory;
    }

    /**
     * setItems function
     *
     * @param array $items
     *
     * @return void
     */
    public function setItems(array $items) {
        foreach ($items as $item) {
            $itemName  = $item[self::INDEX_OF_ITEM_NAME];
            $itemPrice = $item[self::INDEX_OF_ITEM_PRICE];

            $data = [
                'name'  => $itemName,
                'price' => $itemPrice,
            ];

            if ($this->isItemWithSpecialPrice($item)) {
                $data['specialOffer'] = array_slice($item, 2);
                $this->items[$itemName] = $this->itemFactory->getInstance(ItemFactory::ITEM_WITH_SPECIAL_PRICE, $data);
            } else {
                $this->items[$itemName] = $this->itemFactory->getInstance(ItemFactory::ITEM, $data);
            }
        }
    }

    /**
     * getItems function
     *
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * setOrder function
     *
     * @param array $itemNames
     *
     * @return void
     */
    public function setOrder(array $itemNames) {
        $this->order = array_count_values($itemNames);
    }

    /**
     * getOrder function
     *
     * @return array
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * calculateTotalPrice function
     *
     * @return int
     */
    public function calculateTotalPrice() {
        $totalPrice = 0;
        foreach ($this->order as $itemName => $itemCount) {
            $totalPrice += $this->items[$itemName]->calculatePrice($itemCount, $this->getOrder());
        }

        return $totalPrice;
    }

    /**
     * isItemWithSpecialPrice function
     *
     * @param array $item
     *
     * @return boolean
     */
    private function isItemWithSpecialPrice(array $item) {
        return count($item) > 2;
    }
}
