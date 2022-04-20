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
$supermarketController->setProducts($itemsData);
$supermarketController->setOrder($order);

$outputService = new OutputService;
$outputService->print($supermarketController->calculateTotalPrice());