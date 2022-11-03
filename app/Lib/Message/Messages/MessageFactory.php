<?php

namespace App\Lib\Message\Messages;

//use App\Lib\Message\Messages\MessageDefault;

class MessageFactory {

    //private $namespace = "App\Lib\Message\Messages\\";

    public function create(string $type, int $id, array $param) {

        $product = /*$this->namespace.*/"Message".ucfirst($type);

        if(class_exists($product)){
          return new $product($id,$param);
        } else {
          return new MessageDefault($id, $param);
        }
    }

}