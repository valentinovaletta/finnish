<?php 

namespace App\Http\Classes;

abstract class Message {
  protected $text = null;
  protected $menu = null;
  
  public function __construct(){

  }

  public function getText(){
    return $this->text;
  }
  public function getMenu(){
    return $this->menu;
  }  
}

class Message_Start extends Message {
  protected $text = "Hello!\r\nI'm a Finnish Language Bot. Nice to meet you!";
  protected $menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);
}

class Message_Default extends Message {
    protected $text = 'This is test message';
    protected $menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);
}