<?php

namespace App\Services\BotZavod\MessageFactory;

class MessageCallMe extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard(json_encode(["inline_keyboard" => [[["text" => "Назад","callback_data" => "StartAgain/"]]]]));
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "Я отправил сообщение менеджеру, который сможет вам перезвонить, но ему нужен ваш номер телефона!\nПожалуйста, напишите мне ваш номер телефона в формате 89112345678.", 'reply_markup'=>$this->keyboard]]);
    }

}