<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

use App\Services\TelegramAPI\TelegramAPI;
use App\Services\BotZavod\MessageFactory\MessageFactory;
use App\Services\normalizeDataService\normalizeTelegramDataService;

class TelegramEnEnBotController extends BaseController
{
    public function index(Request $request) {

        $messageFactory = new MessageFactory(new normalizeTelegramDataService($request));
        $messageFactoryObj = $messageFactory->create();
        
        $telegramMessage =  $messageFactoryObj->getMessage();

        foreach(json_decode($telegramMessage) as $message){
            TelegramAPI::Request($message->method, $message->param);
            usleep( 200000 );
        }
        
    }

}