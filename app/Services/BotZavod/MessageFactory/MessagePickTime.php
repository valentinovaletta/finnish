<?php

namespace App\Services\BotZavod\MessageFactory;
use Illuminate\Support\Facades\Cache;

class MessagePickTime extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        
        $timeArray = $this->createTimeArray();
        $this->setKeyboard(            
            $keyboard = json_encode([
                "inline_keyboard" => $timeArray
            ])
        );
        $cache = $this->cache($this->chatId, $this->param['commandArg']);
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "Вы выбрали ".$this->param['commandArg']." \nТеперь выберите нужное время", 'reply_markup'=>$this->keyboard]]);
    }

    private function createTimeArray(){
        $j = 0;
        $k = 0;

        for ($i=9; $i<=13; $i++) {
            $firstTimeSlot[$j]['text'] = $i.":00";
            $firstTimeSlot[$j]['callback_data'] = 'makeOrder/'.$i;
            $j++;
        }

        for ($i=14; $i<=18; $i++) {
            $secondTimeSlot[$k]['text'] = $i.":00";
            $secondTimeSlot[$k]['callback_data'] = 'makeOrder/'.$i;
            $k++;
        }

        return [                    
            $firstTimeSlot,
            $secondTimeSlot
        ];
    }

    private function cache($chatId, $commandArg){
        $cacheValue = json_decode(Cache::pull($chatId), true);
        $cacheValue['date'] = $commandArg;
        return Cache::put($chatId, json_encode($cacheValue), 180);
    }   
}