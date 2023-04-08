<?php

namespace App\Services\EnEn\MessageFactory;

class MessageStartAgain extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard();
        $this->setMessage(['method' => 'editMessageText', 'delay' => 200000, 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => __('telegram.MessageStart'), 'parse_mode' => 'HTML', 'reply_markup'=>$this->keyboard]]);
    }
}