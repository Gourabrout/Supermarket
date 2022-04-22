<?php

use PHPUnit\Framework\Assert;
use Behat\Behat\Context\Context;
use Supermarket\Controllers\SupermarketController;
use Supermarket\Factories\ItemFactory;

class SupermarketTest implements Context
{
    private $items = [];
    private $supermarket;
    
    public function __construct()
    {
        $this->supermarket = new SupermarketController(new ItemFactory);
    }

    /**
     * @Given there is one item with name :arg1 and cost :arg2
     */
    public function thereIsOneItemWithNameAndCost($arg1, $arg2)
    {
        $this->items[$arg1] = [$arg1, $arg2];
    }

    /**
     * @Given our order is like this :arg1
     */
    public function ourOrderIsLikeThis($arg1)
    {
        $this->supermarket->setOrder(str_split($arg1));
    }

    /**
     * @Then Our total cost should be :arg1
     */
    public function ourTotalCostShouldBe($arg1)
    {
        Assert::assertSame($this->supermarket->calculateTotalPrice(), (int)$arg1);
    }

    /**
     * @Given set items in supermarket
     */
    public function setItemsInSupermarket()
    {
        $this->supermarket->setItems($this->items);
    }

    /**
     * @Given there is one special price on item :arg1 and if you buy :arg2 of them you should pay :arg3
     */
    public function thereIsOneSpecialPriceOnItemAndIfYouBuyOfThemYouShouldPay($arg1, $arg2, $arg3)
    {
        $this->items[$arg1] = array_merge($this->items[$arg1], ["$arg2-$arg3"]);
    }

    /**
     * @Given there is one special price on item :arg1 and if you buy with :arg2 then you should pay :arg3
     */
    
    public function thereIsOneSpecialPriceOnItemAndIfYouBuyOfWithThenYouShouldPay($arg1, $arg2, $arg3)
    {
        $this->items[$arg1] = array_merge($this->items[$arg1], ["$arg2-$arg3"]);
    }
}
