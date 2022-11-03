<?php

namespace App\Lib\Message\Messages;

class MessageStart extends Message{

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $this->text = "Hello!\r\nThis is a Start message!\r\nYour id is $this->id\r\nYour name is ".$this->param['name']."\r\nYour lang is ".$this->param['lang'];
    }

    public function getText(){
        return $this->text;
    }   
}