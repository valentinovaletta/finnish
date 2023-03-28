<?php

namespace App\Services\BotZavod\MessageFactory;

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
                            "text" => "Записаться на прием",
                            "callback_data" => "PickDate/"
                        ],
                        [
                            "text" => "Больше Информации",
                            "callback_data" => "Info/"
                        ],
                        [
                            "text" => "Записать телефон",
                            "callback_data" => "Phone/"
                        ],
                        [
                            "text" => "Перезвоните мне",
                            "callback_data" => "CallMe/"
                        ]
                    ]               
                ]
            ]);
        }
        $this->keyboard = $keyboard;
    }
}