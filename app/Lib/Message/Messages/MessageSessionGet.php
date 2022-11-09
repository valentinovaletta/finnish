<?php

namespace App\Lib\Message\Messages;

class MessageSessionGet extends Message{

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $this->text = session('key');    
    }

    public function getText(){
        return $this->text;
    }
 
}