<?php

class SupermarketCheckout {
    private $orders;
    private $items = [];

    public function setItems(array $items)
    {
        foreach ($items as $item) {
            if (count($item) > 2) {
                $itemObject = new ItemWithSpecialPrice($item[0], $item[1]);
                for ($i=2; $i < count($item); $i++) { 
                    $specialOffer = explode('-', $item[$i]);
                    if(is_numeric($specialOffer[0])) {
                        $itemObject->setSpecialPrice((int)$specialOffer[0], (int)$specialOffer[1]);
                    } else {
                        $itemObject->setCombineSpecialPrice((string)$specialOffer[0], (int)$specialOffer[1]);
                    }
                    
                }

                $this->items[$item[0]] = $itemObject;
            } else {
                $this->items[$item[0]] = new Item($item[0], $item[1]);
            }

        }
    }

    public function setOrder(array $itemNames)
    {
        $this->order = array_count_values($itemNames);
    }

    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->order as $itemName => $itemCount) {
            $totalPrice += $this->items[$itemName]->calculatePrice($itemCount, $this->order);
        }

        return $totalPrice;
    }
}

class Item {
    protected $name;
    protected $price;
    public function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function calculatePrice(int $itemCount, array $orders)
    {
        return $itemCount * $this->price;
    }
}


class ItemWithSpecialPrice extends Item {
    private $specialPrices = [];
    private $combineSpecialPrice = [];

    public function setSpecialPrice($count, $price)
    {
        $this->specialPrices[$count] = $price;
    }

    public function setCombineSpecialPrice($comboSKU, $price)
    {
        $this->combineSpecialPrice[$comboSKU] = $price;
    }

    public function calculatePrice(int $count, array $orders)
    {
        $price = 0;
        foreach ($this->combineSpecialPrice as $combineSKU => $combineItemPricr) {
            if (!empty($orders[$combineSKU])) {
                $combineCountApplied = ($count >= $orders[$combineSKU])?$orders[$combineSKU]:$count;
                $price += $combineCountApplied * $combineItemPricr;
                $count = $count - $combineCountApplied;
            }
            
        }

        if($count > 0) {
            krsort($this->specialPrices);
            foreach ($this->specialPrices as $itemCount => $itemPrice) {
                if ($count >= $itemCount) {
                    $price += ((int)($count / $itemCount) * $itemPrice);
                    $count = $count % $itemCount;
                }
            }
            $price += $count * $this->price;
        }
        return $price;
    }
}

$count = (int)fgets(STDIN);

$itemsData = [];
for ($i=0; $i < $count; $i++) { 
    $itemsData[] = explode(' ', str_replace(PHP_EOL, '', fgets(STDIN)));
}

$orderData = explode(' ', str_replace(PHP_EOL, '', fgets(STDIN)));
$supermarketCheckout = new SupermarketCheckout;
$supermarketCheckout->setItems($itemsData);
$supermarketCheckout->setOrder($orderData);
echo $supermarketCheckout->calculateTotalPrice() . PHP_EOL; 