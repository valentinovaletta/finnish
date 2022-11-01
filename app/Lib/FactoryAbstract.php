<?php

namespace App\Lib;

abstract class FactoryAbstract {
     
     public function create($type) {

        $product = "Product".ucwords($type);
        if(class_exists($product)) {
          return new $product();
        } else {
            echo class_exists($product);
            echo $product;
          return new ProductB();
        }
     }
 }