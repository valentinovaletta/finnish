<?php

namespace App\Lib;

abstract class FactoryAbstract {
     
     public function create($type) {
          switch ($type) {
              case'A':
                  return new ProductA();
              case'B':
              default:
                  return new ProductB();
          }
     }
 }