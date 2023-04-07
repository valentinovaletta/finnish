<?php

namespace App\Services\EnEn\MessageFactory;

use Illuminate\Support\Facades\Cache;

use App\Models\User;
use App\Models\Messages;

use Illuminate\Support\Facades\DB;

class MessageCheckAnswer extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        
        $check = $this->checkAnswer($this->param['commandArg']);
        $text = $this->formResponce($check);

        $this->setKeyboard(json_encode(["inline_keyboard" => [[["text" => __('keyboard.GoOn'), "callback_data" => "NewWord/"]]]]));
        $this->setMessage(['method' => 'editMessageText', 'delay' => 200000, 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => $text, 'reply_markup'=>$this->keyboard]]);
    }

    private function checkAnswer($userAnswer){
        $cache = json_decode( Cache::get($this->chatId), true );
        return ['status' => ($cache['id'] == $userAnswer), 'rightAnswer' => $cache['id'], 'rightAnswerText' => $cache['answer'], 'userAnswer' => $userAnswer];
    }

    private function formResponce($check){

        if(!$check['status']){
            User::where('id', $this->chatId)->decrement('points', 1);
            DB::table($this->chatId."_vocabulary_enen")->where('word_id', $check['rightAnswer'])->decrement('points', 1); 
            return __('telegram.IncorrectAnswer', ['answer' => $check['rightAnswerText']]);
        }

        User::where('id', $this->chatId)->increment('points', 3);
        DB::table($this->chatId."_vocabulary_enen")->where('word_id', $check['rightAnswer'])->increment('points', 3);

        $this->messages();

        return __('telegram.CorrectAnswer', ['answer' => $check['rightAnswerText']]);
    }

    private function messages(){

// SELECT messages.id, messages.title, messages.points, users.points FROM messages 
// INNER JOIN users ON messages.id = (users.messages + 1) where users.id = 494963311 and users.points > messages.points 

        DB::enableQueryLog();
        $title = DB::table('messages')
        ->join('users', 'messages.id', '=', ('users.messages' + 1))
        ->select('messages.id as id', 'messages.title as title', 'messages.points as messagesPoints', 'users.points as usersPoints')
        ->where([
            ['users.id', $this->chatId],
            ['users.points', '>', 'messages.points'],
        ])->get();
        $query = DB::getQueryLog();

        $this->setMessage(['method' => 'editMessageText', 'delay' => 4000000, 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => print_r($query, true), 'reply_markup'=>$this->keyboard]]);
        
        return true;
    }

}