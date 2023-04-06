<?php

namespace App\Services\EnEn\MessageFactory;

use App\Models\User;
use App\Models\TagUser;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MessageStart extends Message{

    private $chatId;
    private $param;

    private $user;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;

        $newUser = $this->newUser();
        $this->createNewUser($newUser);

        $this->setKeyboard();
        $this->setMessage(['method' => 'sendSticker', 'delay' => 200000, 'param' => ['chat_id' => $this->chatId, 'sticker' => 'CAACAgIAAxkBAAEd6DFkAagSnQZuZgHkLvX1RV2JdR0Z_gACVB0AAoqR0ElUTMG-FBDOOy4E', 'disable_notification' => true]]);
        $this->setMessage(['method' => 'sendMessage', 'delay' => 200000, 'param' => ['chat_id' => $this->chatId, 'text' => __('telegram.MessageStart'), 'disable_notification' => true, 'reply_markup'=>$this->keyboard]]);
    }

    private function newUser(){
        $this->user = User::firstOrCreate(['id' => $this->chatId, 'name' => $this->param['name'],  'bot' => 'EnEn']);
        return $this->user->wasRecentlyCreated;
    }

    private function createNewUser($newUser){
        if( $newUser ){
            // create new user vacabulary set
            Schema::connection('mysql')->create($this->chatId.'_vocabulary_enen', function (Blueprint $table) {
                $table->integer('word_id')->primary()->unique();
                $table->integer('points');
                $table->timestamps();
            });
            // Subscribe new user to first top 100 tags
            $tagsSet = [
                ['tag_id'=>'1', 'user_id'=> $this->chatId]
            ];
            TagUser::insert($tagsSet);
            // add words into user vocabulary table
            $wordsSet = [];
            for($i=1; $i <= 20; $i++){
                $wordsSet[$i] = ['word_id' => $i, 'points' => 0];
            }
            DB::table($this->chatId.'_vocabulary_enen')->insert($wordsSet);
        }
        return true;
    }
}