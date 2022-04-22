Feature: Supermarket
    In order to buy some items and calculate the price of them
    And I need to first define some items
    And I need to create an order 
    Then I can get the total price 

    Scenario: Buy items
        Given there is one item with name A and cost 20
        Given there is one item with name B and cost 15
        And  our order is like this AABBAB
        And  set items in supermarket
        Then Our total cost should be 105

    Scenario: Buy itemWithSpecialPrices
        Given there is one item with name A and cost 15
        Given there is one item with name B and cost 25
        Given there is one special price on item A and if you buy 2 of them you should pay 25
        Given there is one special price on item A and if you buy 3 of them you should pay 35
        Given there is one special price on item B and if you buy 2 of them you should pay 45
        And  our order is like this AAABBAABB
        And  set items in supermarket
        Then Our total cost should be 150

    Scenario: Buy items And itemWithSpecialPrices
        Given there is one item with name A and cost 20
        Given there is one special price on item A and if you buy 2 of them you should pay 35
        Given there is one item with name B and cost 10
        And  our order is like this AAAB
        And  set items in supermarket
        Then Our total cost should be 65

    Scenario: Buy items And itemWithCombineSpecialPrices
        Given there is one item with name A and cost 20
        Given there is one special price on item A and if you buy 2 of them you should pay 35
        Given there is one item with name B and cost 10
        Given there is one item with name C and cost 15
        Given there is one special price on item C and if you buy with B then you should pay 5
        Given there is one special price on item C and if you buy 2 of them you should pay 10
        And  our order is like this AAABBCC
        And  set items in supermarket
        Then Our total cost should be 85

    Scenario: Buy items And itemWithCombineSpecialPrices
        Given there is one item with name A and cost 20
        Given there is one special price on item A and if you buy 2 of them you should pay 35
        Given there is one item with name B and cost 10
        Given there is one item with name C and cost 15
        Given there is one special price on item C and if you buy with B then you should pay 5
        Given there is one special price on item C and if you buy 2 of them you should pay 10
        And  our order is like this AAABBCCCCC
        And  set items in supermarket
        Then Our total cost should be 110
