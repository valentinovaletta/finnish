<?php

namespace app\Lib\Messages;

class Message {

    protected $text;
    protected $menu;

    public function __construct(){
        $this->text = "Hello!\r\nI'm a Finnish Language Bot. Nice to meet you!";
        $this->menu = array("keyboard" =>array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true); 
    }
        
    public function getText(){
      return $this->text;
    }

    public function getMenu(){
        return $this->menu;
    }
  
}