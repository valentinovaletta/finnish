<?php

namespace App\Lib\Message\Messages;

class MessageInfo extends Message{

    private $id;
    private $param;

    private $text = "Hello!\r\nThis is an info message!";
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