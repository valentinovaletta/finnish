<?php

namespace App\Lib;

abstract class FactoryAbstract {
     
     public function create($type) {
/*
        $product = "Product".ucwords($type);
        if(class_exists($product))
        {
          return new $product();
        }
        else {
          return new ProductB();
        }
*/
          switch ($type) {
              case'A':
                  $product = "App\Lib\ProductA";
                  return new $product();
                  //return new ProductA();
              case'B':
              default:
                  return new ProductB();
          }
     }
 }