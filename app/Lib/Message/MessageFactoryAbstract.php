<?php

namespace App\Lib\Message;

abstract class MessageFactoryAbstract {
     
    private $namespace = "App\Lib\\";

    public function create($type) {

        $product = $this->namespace."Message".ucfirst($type);
        if(class_exists($product)){
          return new $product();
        } else {
          return new MessageDefault();
        }
    }
 }