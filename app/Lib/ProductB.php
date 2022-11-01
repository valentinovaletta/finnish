<?php

namespace App\Lib;

class ProductB extends Product {
    private $name = "B";

    public function getName(){
        return $this->name;
    }
}