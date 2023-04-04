<?php

namespace App\Services\EnEn\MessageFactory;

class MessageProfile extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard(json_encode(["inline_keyboard" => [[["text" => "Назад","callback_data" => "StartAgain/"]]]]));
        $this->setMessage(['method' => 'editMessageText', 'delay' => 200000, 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "Profile", 'reply_markup'=>$this->keyboard]]);
    }
}