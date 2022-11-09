<?php

namespace App\Lib\Message\Messages;

use Illuminate\Support\Facades\DB;
use App\Models\Cache;

class MessageMyWords extends Message{

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $words = $this->getWords();
        $text = $this->formQuizEnFi($words);
        $this->setText($text);
    }

    private function getWords(){
        $words = DB::table($this->id.'_vocabulary')
        ->join('en_dictionaries', $this->id.'_vocabulary.word_id', '=', 'en_dictionaries.id')
        ->join('fi_dictionaries', $this->id.'_vocabulary.word_id', '=', 'fi_dictionaries.id')
        ->select($this->id.'_vocabulary.word_id as id', $this->id.'_vocabulary.points as points', 'en_dictionaries.word as enword', 'en_dictionaries.pos as pos', 'en_dictionaries.ts as ts', 'en_dictionaries.img as img', 'fi_dictionaries.word as fiword')
        ->orderBy($this->id.'_vocabulary.points')
        ->inRandomOrder()
        ->take(4)
        ->get();
        return $words;
    }

    private function formQuizEnFi($words){

        // choice right answer 
        $rightAnswerId = $words->first()->id;
        $rightAnsweren = $words->first()->enword;
        $rightAnswerfi = $words->first()->fiword;
        $rightAnswerPos = $words->first()->pos;
        $rightAnswerTs = $words->first()->ts;
        $rightAnswerImg = $words->first()->img;

        $answers = [
            "/{n} ".$words->get(0)->fiword,
            "/{n} ".$words->get(1)->fiword,
            "/{n} ".$words->get(2)->fiword,
            "/{n} ".$words->get(3)->fiword
          ];
        shuffle($answers);
        $rightId = (array_search("/{n} ".$words->get(0)->fiword, $answers)+1);

        // cache right answer and function
        Cache::updateOrCreate(['id' => $this->id],['command' => 'myWords', 'rightId' => $rightId, 'rightAnswer' => $rightAnswerfi]);

        // form a question and answers
        $text = $rightAnsweren."\r\n(".$rightAnswerPos.") [".$rightAnswerTs."] \r\n";
        $text .= "What is it in Finnish?\r\n";

        foreach($answers as $key => $value){
            $text .= preg_replace('/{n}/i', $key++, $value)."\r\n";
        }
        
        // $i = 0;
        // foreach($words as $word){
        //     $text .= "/".++$i." ".$word->fiword."\r\n";
        // }
        return $text;
    }

    private function setText($text){
        $this->text = $text;
    }

    public function getText(){
        return $this->text;
    }
 
}