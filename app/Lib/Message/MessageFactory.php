<?php

namespace App\Lib\Message;

use App\Lib\Message\Messages\MessageDefault;

class MessageFactory {

    private $namespace = "App\Lib\Message\Messages\\";

    public function create(string $type) {

        $product = $this->namespace."Message".ucfirst($type);
        if(class_exists($product)){
          return new $product();
        } else {
          return new MessageDefault();
        }
    }

}