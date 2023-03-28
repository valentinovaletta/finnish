<?php

namespace App\Services\BotZavod\MessageFactory;

class MessageStart extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard();
        $this->setMessage(['method' => 'sendSticker', 'param' => ['chat_id' => $this->chatId, 'sticker' => 'CAACAgIAAxkBAAEd6DFkAagSnQZuZgHkLvX1RV2JdR0Z_gACVB0AAoqR0ElUTMG-FBDOOy4E']]);
        $this->setMessage(['method' => 'sendMessage', 'param' => ['chat_id' => $this->chatId, 'text' => "Здравствуйте, ".$this->param['name']. ". Я БОТ, собранный на БотЗаводе\n\n1) Я могу записать вас на прием.\n2) Я могу рассказать вам дополнитльную информацию о ботах.\n3) Я могу записать ваш номер телефона. \n4) Я могу попросить менеджера перезвонить вам.\n\nИспользуйте одну из кнопок ниже.", 'reply_markup'=>$this->keyboard]]);
    }

}