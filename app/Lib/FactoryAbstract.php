<?php

namespace App\Lib;

abstract class FactoryAbstract {
     
    private $namespace = "App\Lib\\";

    public function create($type) {

        $product = $this->namespace."Product".ucfirst($type);
        if(class_exists($product)){
          return new $product();
        } else {
          return new ProductDefault();
        }
    }
 }