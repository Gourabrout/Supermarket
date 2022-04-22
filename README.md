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

### How can I run it
I define a `Dockerfile` for the project and you can use it like this: <br>
Go to the root of the project (where you can see `Dockerfile`) and then run this commands
```
docker build -t supermarket .
docker run -it --rm supermarket
```
And now you need to set the inputs, for example like this
```
3
A 20
B 15 2-25
C 25 2-45 A-10
A A A B B C C C C C C
```
It means you have three items and the price of `A` is `20` and the price of `B` is `15` and if you buy `2` numbers of `B` you can pay `25` instead of `30` and the price of `C` is `25` and if you buy `2` numbers of `C` you can pay `45` instead of `50` and if you buy a 'A' with 'C' you can pay `10` instead of `25` . <br>
And the end line also show you the order, in this case you buy `3` of `A` and `2` of `B` and `6` of `C`. <br>
(If you want for example read the Service from the file you can just make the new InputService class and implement it from InputInterface and just use it easily, because that part is completly separated from the other part of the code, also you can do it with outputService)
#### Output
```
185
```
And your output will be the total price

#### Multi offers
you can also define multi special offers and the code support it <br>
you should define it like this
```
A 10 3-29 6-55 C-5
```
The structure `a-b` means if you buy `a` count of procuts you can pay `b`<br>
The structure `C-5` means if you buy `A` with `C` then you will pay `5` for each `A` 


#### Unit tests
I use `phpunit` for writing unit tests
```
PHPUnit 9.5.20 #StandWithUkraine

............                                                      12 / 12 (100%)

Time: 00:00.014, Memory: 6.00 MB

OK (12 tests, 20 assertions)

```
And you can run it with this command
```
docker run -it --rm supermarket vendor/bin/phpunit
```

#### Feature tests
I use behat for writing the feature test and I define some scenarios and test the all project functionality in it <br> My scenarios are like this
```
 Scenario: Buy itemWithSpecialPrices
        Given there is one item with name A and cost 15
        Given there is one item with name B and cost 25
        Given there is one special price on item A and if you buy 2 of them you should pay 25
        Given there is one special price on item A and if you buy 3 of them you should pay 35
        Given there is one special price on item B and if you buy 2 of them you should pay 45
        And  our order is like this AAABBAABB
        And  set items in supermarket
        Then Our total cost should be 150
```
And you can run these tests with this command
```
docker run -it --rm supermarket vendor/bin/behat
```
output
```
Feature: Supermarket
    In order to buy some items and calculate the price of them
    And I need to first define some items
    And I need to create an order
    Then I can get the total price

  Scenario: Buy items                               
    Given there is one item with name A and cost 20 
    Given there is one item with name B and cost 15 
    And our order is like this AABBAB               
    And set items in supermarket                    
    Then Our total cost should be 105              

  Scenario: Buy itemWithSpecialPrices                                                     
    Given there is one item with name A and cost 15                                       
    Given there is one item with name B and cost 25                                       
    Given there is one special price on item A and if you buy 2 of them you should pay 25 
    Given there is one special price on item A and if you buy 3 of them you should pay 35 
    Given there is one special price on item B and if you buy 2 of them you should pay 45 
    And our order is like this AAABBAABB                                                  
    And set items in supermarket                                                          
    Then Our total cost should be 150                                                     

  Scenario: Buy items And itemWithSpecialPrices                                           
    Given there is one item with name A and cost 20                                       
    Given there is one special price on item A and if you buy 2 of them you should pay 35 
    Given there is one item with name B and cost 10                                       
    And our order is like this AAAB                                                       
    And set items in supermarket                                                          
    Then Our total cost should be 65                                                      

  Scenario: Buy items And itemWithCombineSpecialPrices                                     
    Given there is one item with name A and cost 20                                        
    Given there is one special price on item A and if you buy 2 of them you should pay 35  
    Given there is one item with name B and cost 10                                        
    Given there is one item with name C and cost 15                                        
    Given there is one special price on item C and if you buy with B then you should pay 5 
    Given there is one special price on item C and if you buy 2 of them you should pay 10  
    And our order is like this AAABBCC                                                     
    And set items in supermarket                                                           
    Then Our total cost should be 85                                                       

  Scenario: Buy items And itemWithCombineSpecialPrices                                     
    Given there is one item with name A and cost 20                                        
    Given there is one special price on item A and if you buy 2 of them you should pay 35  
    Given there is one item with name B and cost 10                                        
    Given there is one item with name C and cost 15                                        
    Given there is one special price on item C and if you buy with B then you should pay 5 
    Given there is one special price on item C and if you buy 2 of them you should pay 10  
    And our order is like this AAABBCCCCC                                                  
    And set items in supermarket                                                           
    Then Our total cost should be 110                                                      

5 scenarios (5 passed)
37 steps (37 passed)
0m0.03s (9.53Mb)

```

### use Makefile
I also define a Makefile for myself to make life easier and that is like this
```
setup:
	docker build -t supermarket .
run:
	docker run -it --rm supermarket
unitTest:
	docker run -it --rm supermarket vendor/bin/phpunit
behatTest:		
	docker run -it --rm supermarket vendor/bin/behat
```
And if you want you can use it for example run the project like this
```
make setup
make run
```
