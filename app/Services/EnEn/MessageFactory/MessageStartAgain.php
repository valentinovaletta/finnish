<?php

namespace App\Services\EnEn\MessageFactory;

class MessageStartAgain extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard();
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "Здравствуйте, ".$this->param['name']. ". Я БОТ, собранный на БотЗаводе\n\n1) Я могу записать вас на прием.\n2) Я могу рассказать вам дополнитльную информацию о ботах.\n3) Я могу записать ваш номер телефона. \n4) Я могу попросить менеджера перезвонить вам.\n\nИспользуйте одну из кнопок ниже.", 'reply_markup'=>$this->keyboard]]);
    }
}