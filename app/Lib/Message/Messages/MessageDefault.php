<?php

namespace App\Lib\Message\Messages;

use App\Lib\Message\Message;

class MessageDefault extends Message {
    private $text = "Hello!\r\nThis is a default message!";
    private $menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }  
}