<?php

namespace App\Lib\Message\Messages;

use App\Models\Tag;
use App\Models\Cache;

class MessageNewWords extends Message {

    private $id;
    private $param;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $wordSets = $this->getWordSets();
        $this->setCache();
        $this->setText($wordSets);
    }

    private function getWordSets(){
        $wordSets = Tag::orderBy('id')->get();

        $text = "There are new Sets of Words such as\r\n";
        foreach($wordSets as $set){
            $text .= $menu[] = "/".$set->id.") ". $set->tag_name."\r\n";
        }
        $text .= "Click on Word Set Id to add new words to your vocabulary.";

        $this->setMenu($menu);

        return json_encode([
            0 => ['method' => 'sendMessage', 'content' => 'text', '', 'value' => $text]
        ]);    

        return $wordSets;
    }

    private function setCache(){
        Cache::updateOrCreate(['id' => $this->id],['command' => 'NewWords']);
    }
    private function setText($text){
        $this->text = $text;
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