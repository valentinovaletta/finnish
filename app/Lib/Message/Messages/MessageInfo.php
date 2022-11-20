<?php

namespace App\Lib\Message\Messages;

class MessageInfo extends Message{

    private $id;
    private $param;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $sticker = rand(0,3);

        $this->text = json_encode([
            0 => ['method' => 'sendSticker', 'content' => 'sticker', 'value' => __("stickers.info.$sticker")],
            1 => ['method' => 'sendMessage', 'content' => 'text', 'value' => __('telegram.info', ['id' => $this->id, 'name' => $this->param['name'], 'lang' => $this->param['lang']]) ]
        ]);

        $this->setMenu(["/myWords", "/newWords", "/info"]);

    }

    public function getText(){
        return $this->text;
    }
 
    private function setMenu($menu){
        $this->menu = array("keyboard" => array($menu),"resize_keyboard" => true,"one_time_keyboard" => true);
    }
    
    public function getMenu(){
        return $this->menu;
    }   
}