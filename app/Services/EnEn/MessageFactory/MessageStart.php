<?php

namespace App\Services\EnEn\MessageFactory;

class MessageStart extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard();
        $this->setMessage(['method' => 'sendSticker', 'param' => ['chat_id' => $this->chatId, 'sticker' => 'CAACAgIAAxkBAAEd6DFkAagSnQZuZgHkLvX1RV2JdR0Z_gACVB0AAoqR0ElUTMG-FBDOOy4E']]);
        $this->setMessage(['method' => 'sendMessage', 'param' => ['chat_id' => $this->chatId, 'text' => __('telegram.MessageStart'), 'reply_markup'=>$this->keyboard]]);
    }

}