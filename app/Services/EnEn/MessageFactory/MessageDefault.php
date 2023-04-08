<?php

namespace App\Services\EnEn\MessageFactory;

class MessageDefault extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;

        $this->setKeyboard();
        $this->setMessage(['method' => 'sendMessage', 'delay' => 200000, 'param' => ['chat_id' => $this->chatId, 'text' => __('telegram.MessageStart'), 'disable_notification' => true, 'parse_mode' => 'HTML', 'reply_markup'=>$this->keyboard]]);
    }
}