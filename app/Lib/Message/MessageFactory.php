<?php

namespace App\Lib\Message;

use App\Lib\Message\Messages\MessageDefault;

class MessageFactory {

    private $namespace = "App\Lib\Message\Messages\\";

    public function create(string $type, int $id, array $param) {

        $message = $this->namespace."Message".ucfirst($type);

        if(class_exists($message)){
          return new $message($id,$param);
        } else {
          return new MessageDefault($id, $param);
        }
    }

}