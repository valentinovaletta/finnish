<?php

namespace app\Lib\Messages;
//include "ShapeFactory.php";

$carOrder = new CarOrder;
var_dump($carOrder->getCarOrders());
 
$carOrder->order('r');
var_dump($carOrder->getCarOrders());
 
$carOrder->order('s');
var_dump($carOrder->getCarOrders());
