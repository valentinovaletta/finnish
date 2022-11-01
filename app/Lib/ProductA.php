<?php

namespace App\Lib;

class ProductA extends Product{
    private $name = "A";

    public function getName(){
        return $this->name;
    }
}