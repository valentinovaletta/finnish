<?php

namespace App\Services\BotZavod\MessageFactory;

use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Cache;

class MessagePickDate extends Message {

    private $chatId;
    private $param;

    public function __construct(int $chatId, array $param){
        $this->chatId = $chatId;
        $this->param = $param;
        
        $dateArray = $this->createDateArray();
        $this->setKeyboard(            
            json_encode([
                "inline_keyboard" => $dateArray
            ])
        );
        $cache = $this->cache($this->chatId, $this->param['commandArg']);
        $this->setMessage(['method' => 'editMessageText', 'param' => ['chat_id' => $this->chatId, 'message_id' => $this->param['message_id'], 'text' => "Вы выбрали ".$this->param['commandArg']." \nТеперь выберите нужную дату", 'reply_markup'=>$this->keyboard]]);
    }

    private function createDateArray(){

        $firstWeek = [];
        $secondWeek = [];
        $thirdWeek = [];
        $fourthWeek = [];

        $weekOne = CarbonPeriod::between(now(), now()->next('monday'))->filter('isWeekday');
        $weekTwo = CarbonPeriod::between(now()->next('monday'), now()->next('monday')->addDays(6))->filter('isWeekday');
        $weekThree = CarbonPeriod::between(now()->next('monday')->addDays(6), now()->next('monday')->addDays(12))->filter('isWeekday');
        $weekFour = CarbonPeriod::between(now()->next('monday')->addDays(12), now()->next('monday')->addDays(18))->filter('isWeekday');

        // Iterate over the period
        foreach ($weekOne as $i => $date) {
            $firstWeek[$i]['text'] = $date->format('j.m');
            $firstWeek[$i]['callback_data'] = 'PickTime/'.$date->format('Y-m-d');
        }
        foreach ($weekTwo as $i => $date) {
            $secondWeek[$i]['text'] = $date->format('j.m');
            $secondWeek[$i]['callback_data'] = 'PickTime/'.$date->format('Y-m-d');
        }
        foreach ($weekThree as $i => $date) {
            $thirdWeek[$i]['text'] = $date->format('j.m');
            $thirdWeek[$i]['callback_data'] = 'PickTime/'.$date->format('Y-m-d');
        }
        foreach ($weekFour as $i => $date) {
            $fourthWeek[$i]['text'] = $date->format('j.m');
            $fourthWeek[$i]['callback_data'] = 'PickTime/'.$date->format('Y-m-d');
        }

        return [                    
            $firstWeek,
            $secondWeek,
            $thirdWeek,
            $fourthWeek
        ];
    }

    private function cache($chatId, $commandArg){
        $cacheValue = ['comment' => $commandArg];
        return Cache::put($chatId, json_encode($cacheValue), 180);
    } 
}