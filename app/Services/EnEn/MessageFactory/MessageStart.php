<?php

namespace App\Services\EnEn\MessageFactory;

use App\Models\User;

class MessageStart extends Message{

    private $chatId;
    private $param;

    private $user;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;

        $newUser = $this->newUser();

        $this->setKeyboard();
        $this->setMessage(['method' => 'sendSticker', 'param' => ['chat_id' => $this->chatId, 'sticker' => 'CAACAgIAAxkBAAEd6DFkAagSnQZuZgHkLvX1RV2JdR0Z_gACVB0AAoqR0ElUTMG-FBDOOy4E']]);
        $this->setMessage(['method' => 'sendMessage', 'param' => ['chat_id' => $this->chatId, 'text' => __('telegram.MessageStart'), 'reply_markup'=>$this->keyboard]]);
    }

    private function newUser(){
        $this->user = User::firstOrCreate(['id' => $this->chatId, 'name' => $this->param['name'], 'language' => $this->param['lang'],  'bot' => 'EnEn']);
        return $this->user->wasRecentlyCreated;
    }


}