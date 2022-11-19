<?php

namespace App\Lib\Message\Messages;

use App\Models\User;
use App\Models\TagUser;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MessageStart extends Message{

    private $id;
    private $param;

    private $user;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $newUser = $this->newUser();

        $this->setText($newUser);
        $this->createNewUser($newUser);

    }

    private function newUser(){
        $this->user = User::firstOrCreate(['id' => $this->id, 'name' => $this->param['name'], 'language' => $this->param['lang']]);
        return $this->user->wasRecentlyCreated;
    }

    private function createNewUser($newUser){
        if( $newUser ){
            // create new user vacabulary set
            Schema::connection('mysql')->create($this->id.'_vocabulary', function (Blueprint $table) {
                $table->integer('word_id')->primary()->unique();
                $table->integer('points');
                $table->timestamps();
            });
            // Subscribe new user to first top 100 tags
            $tagsSet = [
                ['tag_id'=>'1', 'user_id'=> $this->id],
                ['tag_id'=>'2', 'user_id'=> $this->id],
                ['tag_id'=>'3', 'user_id'=> $this->id],
                ['tag_id'=>'4', 'user_id'=> $this->id]
            ];
            TagUser::insert($tagsSet);
            // add words into user vocabulary table
            $wordsSet = [];
            for($i=1; $i <= 400; $i++){
                $wordsSet[$i] = ['word_id' => $i, 'points' => 0];
            }
            DB::table($this->id.'_vocabulary')->insert($wordsSet);
        }
        return true;
    }

    private function setText($newUser){

        if($newUser){
            $greeting = "Hello, ".$this->param['name']."! You are a new user here!";
        } else {
            $greeting = "Hello again, ".$this->param['name']."! You have ".$this->user->points." points";
        }

        $this->text = json_encode([
            0 => ['method' => 'sendSticker', 'content' => 'sticker', 'value' =>"CAACAgIAAxkBAAEZ0I9jbNJzhp-ZoHQYVYtbLrN3S6kjPQACVAEAAjDUnRE1EWvwoCBW6ysE"],
            1 => ['method' => 'sendMessage', 'content' => 'text', 'value' => "$greeting\r\nThis is a Start message!"]
        ]);

        $this->setMenu(["/myWords", "/newWords", "/info"]);
    }

    public function getText(){
        return $this->text;
    }   

    private function setMenu($menu){
        $this->menu = array("keyboard" => array($menu),"resize_keyboard" => true,"one_time_keyboard" => true);
    }
    
    public function getMenu(){
        return $this->menu;
    }       
}