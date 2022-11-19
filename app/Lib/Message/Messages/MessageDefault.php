<?php

namespace App\Lib\Message\Messages;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Cache;
use App\Models\Tag;
use App\Models\TagUser;
use App\Models\TagWord;

class MessageDefault extends Message {

    private $id;
    private $param;

    private $text;
    private $menu;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        $cache = Cache::where("id", $this->id)->first();

        if($cache === null){
            $text = json_encode([
                0 => ['method' => 'sendMessage', 'content' => 'text', '', 'value' => __('telegram.defaultNoCommand')]
            ]);
        } else {
            switch ($cache->command) {
                case 'myWords':
                    $text = $this->checkQuiz($cache);
                    break;
                case 'NewWords':
                    $text = $this->wordSetSubscription();
                    break;
                default:
                    $text = json_encode([
                        0 => ['method' => 'sendMessage', 'content' => 'text', '', 'value' => __('telegram.defaultNoCommand')]
                    ]);            
                }
        }
        
        $this->setMenu(["/myWords", "/newWords", "/info"]);
        $this->setText($text);
        $this->clearCache();
    }

    private function checkQuiz($cache)
    {
        $messages = [];
        if( $this->param['command'] == $cache->rightId ){
            $sticker = rand(0,2);
            $messages[] = ['method' => 'sendSticker', 'content' => 'sticker', 'value' => __("telegram.stickers.good.0")];
            $messages[] = ['method' => 'sendMessage', 'content' => 'text', 'value' => __('telegram.defaultCorrect', ['answer' => $cache->rightAnswer])];

            User::where('id', $this->id)->increment('points', 5);
            DB::table($this->id."_vocabulary")->where('word_id', $cache->rightAnswerId)->increment('points', 5);
          } else {
            $messages[] = ['method' => 'sendSticker', 'content' => 'sticker', 'value' => 'CAACAgIAAxkBAAEZ0fdjbQM6T1lg7zkTF7n251_knccYbgACNwEAAjDUnRHKK3SQd2L8ASsE'];
            $messages[] = ['method' => 'sendMessage', 'content' => 'text', 'value' => __('telegram.defaulIncorrect', ['answer' => $cache->rightAnswer])];

            User::where('id', $this->id)->decrement('points', 1);
            DB::table($this->id."_vocabulary")->where('word_id', $cache->rightAnswerId)->decrement('points', 1);
          }

        return json_encode($messages);
    }

    private function wordSetSubscription()
    {
        $tag = Tag::where('id', $this->param['command'])->exists();
        if(!$tag){
            $messages[0] = ['method' => 'sendMessage', 'content' => 'text', '', 'value' => __('telegram.defaultNoWordSet')];
        } else {
            $newWordSet = TagUser::updateOrCreate(['tag_id' => $this->param['command'], 'user_id' => $this->id],[]);
            $text = $this->CopyNewWords($newWordSet->wasRecentlyCreated);

            $messages[0] = ['method' => 'sendMessage', 'content' => 'text', 'value' => __('telegram.defaultSubscribed')];
            $messages[1] = ['method' => 'sendMessage', 'content' => 'text', 'value' => $text];
        }

        return json_encode($messages);
    }

    private function CopyNewWords($newWordSet){
        if( $newWordSet ){
            $wordIds = TagWord::select("word_id", DB::raw("0 as `points`"))->where('tag_id', $this->param['command'])->get();
            $upsert = DB::table($this->id."_vocabulary")->upsert($wordIds->toArray(), []);

            $text = __('telegram.defaultUpsert', ['upsert' => $upsert]); 
        } else {
            $text = __('telegram.defaultAllWords');
        }
        return $text;
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

    private function setMenu($menu){
        $this->menu = array("keyboard" => array($menu),"resize_keyboard" => true,"one_time_keyboard" => true);
    }
    
    public function getMenu(){
        return $this->menu;
    }     
}