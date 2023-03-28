<?php

namespace App\Services\BotZavod\MessageFactory;

class MessageDefault extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;

        $this->setKeyboard();

        $phone = $this->isPhoneNumber($this->param['command']);
        $text = $phone['status']?"Я отправил менеджеру ваш телефон ".$phone['phone']."\nОн перезвонит вам в ближайшее время.":"Вы написали ".$phone['phone']."\nПохоже, что это неправильный номер телефона, пожалуйста, напишите ваш номер еще раз.";


        $this->setMessage(['method' => 'sendMessage', 'param' => ['chat_id' => $this->chatId, 'text' => $text/*."\n\nDefault ".$this->param['command']." ".$this->param['commandArg']*/, 'reply_markup'=>$this->keyboard]]);
    }

    public function isPhoneNumber($message){

        $numbers = preg_replace('/\D/', '', $message);
        $status = strlen($numbers) >= 10 ? true : false;

        return ['status' => $status, 'phone' => $numbers];
    }
}