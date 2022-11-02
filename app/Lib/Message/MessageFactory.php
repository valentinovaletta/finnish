<?php

namespace App\Lib\Message;

class MessageFactory {

    private $namespace = "App\Lib\Message\\";

    public function create($type) {

        $product = $this->namespace."Message".ucfirst($type);
        if(class_exists($product)){
          return new $product();
        } else {
          return new MessageDefault();
        }
    }

}