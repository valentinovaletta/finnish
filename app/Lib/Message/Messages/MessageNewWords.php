<?php

namespace App\Lib\Message\Messages;

use App\Models\Tag;
use App\Models\TagUser;

class MessageNewWords extends Message {

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $wordSets = $this->getWordSets();
        $this->setText($wordSets);
    }

    private function getWordSets(){
        $wordSets = Tag::orderBy('id')->get();

        $text = "There are new such Word Sets as\r\n";
        foreach($wordSets as $set){
            $text .= "/".$set->id.") ". $set->tag_name."\r\n";
        }
        $text .= "Click on Word Set Id to subscribe on it.";

        return json_encode([
            0 => ['method' => 'sendMessage', 'content' => 'text', '', 'value' => $text]
        ]);    

        return $wordSets;
    }

    private function setText($text){
        $this->text = $text;
    }

    public function getText(){
        return $this->text;
    }
}