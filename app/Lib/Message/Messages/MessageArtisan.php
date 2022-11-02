<?php

namespace App\Lib\Message\Messages;
use Illuminate\Support\Facades\Artisan;

class MessageArtisan extends Message {

    private $id;
    private $param;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        Artisan::call('migrate', ['--force' => true,]);

        $this->text = "Hello!\r\nThis is a Artisan message!\r\n".Artisan::output();
        $this->menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);
    }

    public function getText(){
        return $this->text;
    }
    public function getMenu(){
        return $this->menu;
    }  
}