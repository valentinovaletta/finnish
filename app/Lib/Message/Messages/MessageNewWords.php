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

/*
        $words = DB::table('tags')
        ->leftJoin('tag_users', 'tags.id', '=', 'tag_users.tag_id')
        ->select('tags.*')
        ->inRandomOrder()
        ->take(5)
        ->get();
        return $words;

Select      t1.*
From        tags t1
Left Join   tag_users t2  On  t1.id = t2.tag_id And t2.user_id = 494963311
Where       t2.tag_id Is Null

*/

        $text = __('telegram.ThereAreNew');
        foreach($wordSets as $set){
            $text .= $menu[] = "/".$set->id.") ". $set->tag_name."\r\n";
        }
        $text .= __('telegram.ClickOnID');

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