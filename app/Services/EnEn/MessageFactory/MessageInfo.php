<?php

namespace App\Services\EnEn\MessageFactory;

class MessageInfo extends Message{

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        $this->setKeyboard(json_encode(["inline_keyboard" => [[["text" => "Назад","callback_data" => "StartAgain/"]]]]));
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "Боты могут автоматически обрабатывать и отправлять сообщения. \nПользователи могут взаимодействовать с ботами при помощи сообщений, отправляемых через чаты. \nМы можем создать и настроить бота, который будет выполнять все рутинные задачи и отвечать на все типичные вопросы ваших пользователей и клиентов.\nПримеры других ботов:\n- Бот записи на автосервис https://t.me/TestAutoServiceBot\n- Бот для изучения английских слов https://t.me/New9wordsBot", 'reply_markup'=>$this->keyboard]]);
    }
}