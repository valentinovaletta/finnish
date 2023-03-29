<?php

namespace App\Services\EnEn\MessageFactory;
use Illuminate\Support\Facades\Cache;

class MessageMakeOrder extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        
        $this->setKeyboard(json_encode(["inline_keyboard" => [[["text" => "Назад","callback_data" => "StartAgain/"]]]]));
        $dateTime = $this->cache($this->chatId, $this->param['commandArg']);
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "$dateTime вы запланировали визит к нам. Пожалуйста, оставьте ваш номер телефона (Простым сообщением), чтобы мы могли связаться в случае, если это будет необходимо. ", 'reply_markup'=>$this->keyboard]]);
    }

    private function cache($chatId, $commandArg){
        $cacheValue = json_decode(Cache::pull($chatId), true);
        return $cacheValue['date'].' '.$commandArg.':00';
    }
}