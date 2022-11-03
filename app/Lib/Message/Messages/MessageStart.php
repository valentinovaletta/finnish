<?php

namespace App\Lib\Message\Messages;

class MessageStart extends Message{

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $this->text = "Hello!\r\n
            This is a Start message!\r\n
            Your id is $this->id\r\n
            Your name is ".$this->param['name']."\r\n
            Your lang is ".$this->param['lang'];
    }

    public function getText(){
        return $this->text;
    }   
}