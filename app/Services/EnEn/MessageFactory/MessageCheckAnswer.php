<?php

namespace App\Services\EnEn\MessageFactory;

use Illuminate\Support\Facades\Cache;

class MessageCheckAnswer extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        
        $check = $this->checkAnswer($this->param['commandArg']);

        if(!$check){
            $text = "(".$check.")".__('telegram.IncorrectAnswer', ['answer' => Cache::get($this->chatId)]);
        } else {
            $text = "(".$check.")".__('telegram.CorrectAnswer', ['answer' => $this->param['commandArg']]);
        }

        $this->setKeyboard(json_encode(["inline_keyboard" => [[["text" => __('keyboard.GoOn'), "callback_data" => "NewWord/"]]]]));
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => $text, 'reply_markup'=>$this->keyboard]]);
    }

    private function checkAnswer($userAnswer){
        return Cache::get($this->chatId) == $userAnswer;
    }

}