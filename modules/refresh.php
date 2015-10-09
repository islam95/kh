<?php
require_once("../include/autoload.php");

$basket = new Basket();

$print = array();

$print['items'] = $basket->numOfItems;
$print['total'] = number_format($basket->totalValue, 2);

echo json_encode($print);
