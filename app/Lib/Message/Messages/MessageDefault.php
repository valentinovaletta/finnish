<?php

namespace App\Lib\Message\Messages;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Cache;

class MessageDefault extends Message {

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $cache = Cache::where("id", $this->id)->first();

        if($cache === null){
            $text = json_encode([
                0 => ['method' => 'sendMessage', 'content' => 'text', '', 'value' => "Default"]
            ]); 
        } else {
            $text = $this->checkQuiz($cache);
        }
        $this->setText($text);
        $this->clearCache();
    }

    private function checkQuiz($cache)
    {
        $messages = []; 
        if( $this->param['command'] == $cache->rightId ){
            $messages[] = ['method' => 'sendSticker', 'content' => 'sticker', 'value' => 'CAACAgIAAxkBAAETkGNiblYnE7xLE5GJ1kABRAaf3WTd4QACrxQAAs7y2UmyHBuHGFJROCQE'];
            $messages[] = ['method' => 'sendMessage', 'content' => 'text', 'value' => "Yeap! It is $cache->rightAnswer!\r\nYou scored 5 points\r\nNew /myWord ?"];

            User::where('id', $this->id)->increment('points', 5);
            DB::table($this->id."_vocabulary")->where('word_id', $cache->rightId)->increment('points', 5);
          } else {
            $messages[] = ['method' => 'sendSticker', 'content' => 'sticker', 'value' => 'CAACAgIAAxkBAAEVJTJirgrIonNCuE8zH9G922WV4e4tmQACDQADwDZPE6T54fTUeI1TJAQ'];
            $messages[] = ['method' => 'sendMessage', 'content' => 'text', 'value' => "Nope. You've lost a point\r\nRight answer was $cache->rightAnswer!\r\nNew /myWord ?"];

            User::where('id', $this->id)->decrement('points', 1);
            DB::table($this->id."_vocabulary")->where('word_id', $cache->rightId)->decrement('points', 1);
          }

        return json_encode($messages);

    }

    private function clearCache(){
        return Cache::where('id',$this->id)->delete();
    }

    private function setText($text){
        $this->text = $text;
    }

    public function getText(){
        return $this->text;
    } 
}