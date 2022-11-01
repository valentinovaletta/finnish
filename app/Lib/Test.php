<?php

namespace App\Lib;

$factory = new Factory();
$product = $factory->create('B');
echo $product -> getName();