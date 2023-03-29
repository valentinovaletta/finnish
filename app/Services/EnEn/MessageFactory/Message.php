<?php

namespace App\Services\EnEn\MessageFactory;

abstract class Message{

    protected $keyboard;
    protected $message = [];

    abstract public function __construct(int $id, array $param);

    protected function setMessage($message){
        $this->message[] = $message;
    }
    
    public function getMessage(){
        return json_encode($this->message);
    }

    protected function setKeyboard($keyboard = null){
        if(!$keyboard){
            $keyboard = json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => __('keyboard.Start'),
                            "callback_data" => "NewWord/"
                        ],                        
                        [
                            "text" => __('keyboard.Profile'),
                            "callback_data" => "Profile/"
                        ],
                        [
                            "text" => __('keyboard.Info'),
                            "callback_data" => "Info/"
                        ]
                    ]
                ]
            ]);
        }
        $this->keyboard = $keyboard;
    }
}