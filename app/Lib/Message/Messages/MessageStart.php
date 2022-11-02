<?php

namespace App\Lib\Message\Messages;

class MessageStart extends Message{

    private $id;
    private $param;

    private $text = "Hello!\r\nI'm a Finnish Language Bot. Nice to meet you!";
    private $menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);

    public function __construct(int $id, array $param){
        $this -> id = $id;
        $this -> param = $param;
    }

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }    
}