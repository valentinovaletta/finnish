<?php

namespace App\Lib\Message\Messages;

use App\Models\User;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MessageStart extends Message{

    private $id;
    private $param;

    private $user;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $newUser = $this->newUser();
        $this->setText($newUser);
    }

    private function newUser(){
        $this->user = User::firstOrCreate(['id' => $this->id, 'name' => $this->param['name'], 'language' => $this->param['lang']]);

        if( $this->user->wasRecentlyCreated ){
            Schema::connection('mysql')->create($this->id.'_vocabulary', function (Blueprint $table) {
                $table->integer('word_id')->primary()->unique();
                $table->integer('points');
                $table->timestamps();
            });    
        }

        return $this->user->wasRecentlyCreated;
    }
    private function setText($newUser){

        if($newUser){
            $greeting = "Hello, ".$this->param['name']."! You are a new user here!";
        } else {
            $greeting = "Hello again, ".$this->param['name']."! You have ".$this->user->points." points";
        }

        $this->text = "$greeting\r\nThis is a Start message!";
    }

    public function getText(){
        return $this->text;
    }   
}