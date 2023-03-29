<?php

namespace App\Services\EnEn\MessageFactory;

class MessageDefault extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;

        $this->setKeyboard();
        $this->setMessage(['method' => 'sendMessage', 'param' => ['chat_id' => $this->chatId, 'text' => __('telegram.MessageStart'), 'reply_markup'=>$this->keyboard]]);
    }
}