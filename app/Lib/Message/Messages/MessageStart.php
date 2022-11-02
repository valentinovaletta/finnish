<?php

namespace App\Lib\Message\Messages;

use App\Models\User;

class MessageStart extends Message{

    private $id;
    private $param;

    private $user;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $this->user = User::firstOrCreate(['id' => $this->id, 'name' => $this->param['name'], 'language' => $this->param['lang']]);

        $this->text = "Hello!\r\nThis is a Start message!\r\nYour id is $this->id\r\nYour name is ".$this->param['name']."\r\nYour lang is ".$this->param['lang']."\r\nUser object is ".print_r($this->user, true);
        $this->menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);
    }

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }    
}