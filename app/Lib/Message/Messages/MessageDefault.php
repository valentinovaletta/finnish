<?php

namespace App\Lib\Message\Messages;

class MessageDefault extends Message {

    private $id;
    private $param;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $this->text = "Hello!\r\nThis is a Default message!\r\nYour id is $this->id\r\nYour name is ".$this->param['name']."\r\nYour lang is ".$this->param['lang'];
        $this->menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);
    }

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }  
}