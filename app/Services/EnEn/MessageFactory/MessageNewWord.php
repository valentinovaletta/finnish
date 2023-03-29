<?php

namespace App\Services\EnEn\MessageFactory;

use Illuminate\Support\Facades\DB;
use App\Models\Cache;

class MessageNewWord extends Message{

    private $chatId;
    private $param;

    private $quizFunctions = [0 => 'DefenitionToWord', 1 => 'DefenitionToWord'];

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;

        $words = $this->getWords();
        $quizfunc = $this->quizFunctions[rand(0, count($this->quizFunctions)-1 )];
        $text = json_decode($this->$quizfunc($words));

        $this->setKeyboard(json_encode(["inline_keyboard" => [  ]]));
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => $text->question ."\n\n". $text->answers, 'reply_markup'=>$this->keyboard]]);
    }

    private function getWords(){
        $words = DB::table($this->chatId.'_vocabulary_enen')
        ->join('en_dictionaries', $this->chatId.'_vocabulary_enen.word_id', '=', 'en_dictionaries.id')
        ->join('fi_dictionaries', $this->chatId.'_vocabulary_enen.word_id', '=', 'fi_dictionaries.id')
        ->select($this->chatId.'_vocabulary_enen.word_id as id', $this->chatId.'_vocabulary_enen.points as points', 'en_dictionaries.word as enword', 'en_dictionaries.pos as pos', 'en_dictionaries.ts as ts', 'en_dictionaries.img as img', 'fi_dictionaries.word as fiword')
        ->orderBy($this->chatId.'_vocabulary_enen.points')
        ->inRandomOrder()
        ->take(4)
        ->get();
        return $words;
    }

    private function DefenitionToWord($words){
        // choice right answer 
        $rightAnswerId = $words->first()->id;
        $rightAnsweren = $words->first()->enword;
        $rightAnswerfi = $words->first()->fiword;
        $rightAnswerPos = $words->first()->pos;
        $rightAnswerTs = $words->first()->ts;
        $rightAnswerImg = $words->first()->img;

        $answers = [
            ["text" => $words->get(0)->fiword, "callback_data" => "ChackAnswer/".$words->get(0)->fiword],
            ["text" => $words->get(1)->fiword, "callback_data" => "ChackAnswer/".$words->get(1)->fiword],
            ["text" => $words->get(2)->fiword, "callback_data" => "ChackAnswer/".$words->get(2)->fiword],
            ["text" => $words->get(3)->fiword, "callback_data" => "ChackAnswer/".$words->get(3)->fiword]
        ];

        shuffle($answers);
  
        // form a question and answers
        $text = $rightAnsweren."\r\n(".$rightAnswerPos.") [".$rightAnswerTs."] \r\n";
        $text .= __('telegram.myWordsWhatisitEnFi');

        return json_encode([
            'question' => $text,
            'answers' => $answers
        ]);    
    }

}