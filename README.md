# Supermarket
### Problem Description
we should implement the code for a supermarket checkout process that calculates the total price of some
items.
An item has the following attributes: <br>
    ● Name <br>
    ● Unit Price <br>
Our items are priced individually. Some items are multi-priced: buy n of them, and they’ll cost
you less than buying them individually. For example, item ‘B’ might cost $30 individually, but this
week we have a special offer: buy three ‘B’s and they’ll cost you $80.
Here is an example of prices: <br>

| Name | Unit Price | Special Price |
| :---         |     :---:      |          ---: |
| A     | $40       | 3 for $100 |
| B     | $30       | 2 for $55<br> 3 for $80|
| C     | $20       | 10 if purchased with an 'A'|
| D     | $15       ||

Our checkout accepts items in any order, so that if we scan a B, an A, and another B, we’ll
recognize two B’s and price them at 55 (for a total price so far of 95). Because the pricing
changes frequently, we need to be able to pass in a set of pricing rules each time we start
handling a checkout transaction. <br>
Here are some examples of cases:

| Items | Total
| :---         |     :---:      |
| A, B     | $70       |
| A, A     | $80       |
| A, A, A     | $100       |
| C, D, B, A     | $95       |


## Code Description

### Code Structure
Our project code are in the `src` directory so lets check files in this directory
```
.
├── Controllers
│   ├── SupermarketController.php
|── Core
│   ├── InputInterface.php
│   ├── ItemInterface.php
│   └── OutputInterface.php
├── Factories
│   └── ItemFactory.php
├── Item
│   ├── Item.php
│   └── ItemWithSpecialPrice.php
└── Services
    ├── InputService.php
    └── OutputService.php

5 directories, 9 files
```
#### 1.Controllers
We set items and order in `SupermarketController` class and also it get the total price from our items and gathers together and that is the core of our project
#### 2.Core
We use `Core` directory and define our `Interfaces` in it
#### 3.Factories
We use `Factories` directory and define our factory method implementation on it (I define item factory method for creating diffrent type of the item)
#### 4.Item
We use `item` class to define our items and also use `ItemWithSpecialPrice` class to define our item with special price (that is child of `item` and that is a adapter class and have one method to get the special price and overwrite the `calculatePrice` too)
#### 5.Services
We use `Services` for get the data and show them to the client. <br>
I seprate the InputService and OutputService from the code logic and we can for example just define a new InputService class and implement the `InputInterface` and use it in our app  


### How does it works
lets look at the `index.php` file to answer this question
```php
<?php
require './vendor/autoload.php';

use Supermarket\Services\InputService;
use Supermarket\Services\OutputService;
use Supermarket\Controllers\SupermarketController;
use Supermarket\Factories\ItemFactory;

$inputService        = new InputService;
$itemsData = $inputService->getItems();
$order        = $inputService->getOrder();

$itemFactory = new ItemFactory;
$supermarketController    = new SupermarketController($itemFactory);
$supermarketController->setItems($itemsData);
$supermarketController->setOrder($order);

$outputService = new OutputService;
$outputService->print($supermarketController->calculateTotalPrice());
```
First we `new` the `InputService` class and get the `order` and `itemsData` from it.
Then we `new` the `ItemFactory` and inject it to the new SupermarketController class, and SupermarketController class use it to make the new item objects. 
Then we use `setItems` and `setOrder` to set the itemss and order data and finally with `calculateTotalPrice` we calculate the price and show it with help of `print` in `OutputService`.
