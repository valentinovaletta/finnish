<?php

namespace App\Lib\Message\Messages;

use App\Lib\Message\Message;

class MessageInfo extends Message{
    private $text = "Hello!\r\nThis is an info message!";
    private $menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }    
}