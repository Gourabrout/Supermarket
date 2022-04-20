<?php

namespace Supermarket\Item;

use Supermarket\Core\ItemInterface;

class ItemWithSpecialPrice extends Item implements ItemInterface
{
    private $specialPrices = [];
    private $combineSpecialPrice = [];

    /**
     * setSpecialPrice function
     *
     * @param integer $count
     * @param integer $price
     *
     * @return void
     */
    public function setSpecialPrice(int $count, int $price) {
        $this->specialPrices[$count] = $price;
    }

    /**
     * setCombineSpecialPrice function
     *
     * @param string $SKU
     * @param integer $price
     *
     * @return void
     */
    public function setCombineSpecialPrice(string $SKU, int $price)
    {
        $this->combineSpecialPrice[$SKU] = $price;
    }

    /**
     * calculatePrice function
     *
     * @param integer $count
     * @param array $orderItems
     *
     * @return int
     */
    public function calculatePrice(int $count, array $orderItems) {
        $price = 0;

        foreach ($this->combineSpecialPrice as $SKU => $itemPrice) {
            if (!empty($orderItems[$SKU])) {
                $itemCountApplied = ($count >= $orderItems[$SKU])?$orderItems[$SKU]:$count;
                $price += $itemCountApplied * $itemPrice;
                $count = $count - $itemCountApplied;
            }

            if($count == 0) {
                break;
            }
            
        }

        if($count > 0) {
            krsort($this->specialPrices);
            foreach ($this->specialPrices as $itemCount => $itemPrice) {
                if ($count >= $itemCount) {
                    $price += ((int) ($count / $itemCount) * $itemPrice);
                    $count  = $count % $itemCount;
                }
            }

            $price += $count * $this->price;
        }
        return $price;
    }
}
