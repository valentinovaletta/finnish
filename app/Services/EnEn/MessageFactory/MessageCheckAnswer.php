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
        $this->achievements();

        return __('telegram.CorrectAnswer', ['answer' => $check['rightAnswerText']]);
    }

    private function messages(){

        $message = DB::table('messages')
        ->join('users', 'messages.id', '=', DB::raw('users.messages'))
        ->select('messages.id as id', 'messages.title as title', 'messages.points as messagesPoints', 'users.points as usersPoints')
        ->where([
            ['users.id', DB::raw($this->chatId) ],
            ['users.points', '>', DB::raw('messages.points')],
        ])->get();

        if (!$message->isEmpty()){
            User::where('id', $this->chatId)->increment('messages');
            $this->setMessage(['method' => 'editMessageText', 'delay' => 4000000, 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => $message->first()->title, 'reply_markup'=>$this->keyboard]]);
        }
    }

    private function achievements(){

        $achievements = DB::table('achievements')
        ->join('users', 'achievements.id', '=', DB::raw('users.achievements'))
        ->select('achievements.id as id', 'achievements.title as title', 'achievements.points as achievementsPoints', 'achievements.func as achievementsFunc', 'users.achievements as usersAchievements')
        ->where([
            ['users.id', DB::raw($this->chatId) ],
            ['users.points', '>', DB::raw('achievements.points')],
        ])->get();

        if (!$achievements->isEmpty()){
            $runFunc = $achievements->first()->achievementsFunc;
            $this->$runFunc(10);
            User::where('id', $this->chatId)->increment('achievements');
        }

    }

    private function newWords($n){

        $lastWordId = DB::table($this->chatId.'_vocabulary_enen')->orderBy('word_id', 'desc')->limit(1)->get();

        // $wordsSet = [];
        // for($i=1; $i <= 20; $i++){
        //     $wordsSet[$i] = ['word_id' => $i, 'points' => 0];
        // }
        // DB::table($this->chatId.'_vocabulary_enen')->insert($wordsSet);

        $this->setMessage(['method' => 'editMessageText', 'delay' => 4000000, 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => print_r($lastWordId, true)."You've got 10 new words!", 'reply_markup'=>$this->keyboard]]);
    }
}