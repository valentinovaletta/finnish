<?php

namespace App\Lib\Message\Messages;

use Illuminate\Support\Facades\DB;

class MessageMyWords extends Message{

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $this->text = "Hello!\r\nThis is an Info message!\r\nYour id is $this->id
        \r\nYour name is ".$this->param['name']."
        \r\nYour lang is ".$this->param['lang'];
    }

    private function getWords(){
        DB::table($this->id.'_vocabulary')
        ->join('en_dictionaries', $this->id.'_vocabulary.word_id', '=', 'en_dictionaries.id')
        ->join('fi_dictionaries', $this->id.'_vocabulary.word_id', '=', 'fi_dictionaries.id')
        ->select($this->id.'_vocabulary.word_id', $this->id.'_vocabulary.points', 'en_dictionaries.word as enword', 'en_dictionaries.pos as pos', 'en_dictionaries.ts as ts', 'en_dictionaries.img as img', 'fi_dictionaries.word as fiword')
        ->get();
    }

    private function setText(){
        $this->text = "This is a message!";
    }

    public function getText(){
        return $this->text;
    }
 
}