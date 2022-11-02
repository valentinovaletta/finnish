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

        $newUser = $this->newUser();
        $this->setText($newUser);
    }

    private function newUser(){
        $this->user = User::firstOrCreate(['id' => $this->id, 'name' => $this->param['name'], 'language' => $this->param['lang']]);
        return $this->user->wasRecentlyCreated;
    }
    private function setText($newUser){

        if($newUser){
            $greeting = "Hello, ".$this->param['name']."! You are a new user here!";
        } else {
            $greeting = "Hello again, ".$this->param['name']."!";
        }

        $this->text = "$greeting\r\nThis is a Start message!";
        $this->menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);
    }

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }    
}