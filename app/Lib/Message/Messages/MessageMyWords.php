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

        $words = $this->getWords();
        $text = $this->formQuiz($words);
        $this->setText($text);
    }

    private function getWords(){
        $words = DB::table($this->id.'_vocabulary')
        ->join('en_dictionaries', $this->id.'_vocabulary.word_id', '=', 'en_dictionaries.id')
        ->join('fi_dictionaries', $this->id.'_vocabulary.word_id', '=', 'fi_dictionaries.id')
        ->select($this->id.'_vocabulary.word_id', $this->id.'_vocabulary.points', 'en_dictionaries.word as enword', 'en_dictionaries.pos as pos', 'en_dictionaries.ts as ts', 'en_dictionaries.img as img', 'fi_dictionaries.word as fiword')
        ->orderBy($this->id.'_vocabulary.points')
        ->inRandomOrder()
        ->take(4)
        ->get();
        return $words->shuffle();
    }

    private function formQuiz($words){
        $text = 'What is it in Finnish?\r\n';
        $i = 0;
        foreach($words as $word){
            $text .= '/'.++$i.' '.$word->enword.'\r\n';
        }
        return $text;
    }

    private function setText($text){
        $this->text = $text;
    }

    public function getText(){
        return $this->text;
    }
 
}