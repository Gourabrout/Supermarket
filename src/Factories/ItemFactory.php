<?php

namespace Supermarket\Factories;

use Exception;
use Supermarket\Item\Item;
use Supermarket\Item\ItemWithSpecialPrice;

class ItemFactory
{
    const ITEM                    = "item";
    const ITEM_WITH_SPECIAL_PRICE = "itemWithSpecialPrice";

    /**
     * getInstance function
     *
     * @param string $itemName
     * @param array  $data
     *
     * @return Item
     */
    public function getInstance(string $itemName, array $data) {
        if ($itemName === self::ITEM) {
            $item = new Item($data['name'], $data['price']);
        } elseif ($itemName === self::ITEM_WITH_SPECIAL_PRICE) {
            $item = new ItemWithSpecialPrice($data['name'], $data['price']);
            if (isset($data['specialOffer'])) {
                foreach ($data['specialOffer'] as $specialOffer) {
                    $specialOffer      = explode('-', $specialOffer);
                    $specialOfferPrice = (int) $specialOffer[1];
                    if(is_numeric($specialOffer[0])) { 
                        $specialOfferCount = (int) $specialOffer[0];
                        $item->setSpecialPrice($specialOfferCount, $specialOfferPrice);
                    } else {
                        $specialOfferSKU = (string) $specialOffer[0];
                        $item->setCombineSpecialPrice($specialOfferSKU, $specialOfferPrice);
                    }
                    
                }
            }
        } else {
            throw new Exception("$itemName Item Type Not Found.");
        }

        return $item;
    }
}
