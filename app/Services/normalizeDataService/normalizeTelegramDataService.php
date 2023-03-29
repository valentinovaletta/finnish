<?php

namespace App\Services\normalizeDataService;

class normalizeTelegramDataService implements normalizeDataServiceInterface{

    private $normalizedData=[];

    public function __construct($request){
        $this->normalizeData($request);
    }

    private function normalizeData($request){

        if($request->has('callback_query')) {

            $this->normalizedData['method'] = 'editMessageText';

            $this->normalizedData['callback'] = true;
            $this->normalizedData['chatId'] = $this->normalizedData['param']['chat_id'] = $request->input('callback_query.from.id');
            $this->normalizedData['messageId'] = $this->normalizedData['param']['message_id'] = $request->input('callback_query.message.message_id');
            $this->normalizedData['name'] = $this->normalizedData['param']['name'] = $request->input('callback_query.from.first_name');

            $callbackData = explode("/", $request->input('callback_query.data'));
            $this->normalizedData['command'] = $this->normalizedData['param']['command'] = $callbackData[0];
            $this->normalizedData['commandArg'] = $this->normalizedData['param']['commandArg'] = $callbackData[1];
        } else {

            $this->normalizedData['method'] = 'sendMessage';

            $this->normalizedData['callback'] = $this->normalizedData['param']['commandArg'] = false;
            $this->normalizedData['commandArg'] = false;

            $this->normalizedData['chatId'] = $this->normalizedData['param']['chat_id'] = $request->input('message.from.id');
            $this->normalizedData['name'] = $this->normalizedData['param']['name'] = $request->input('message.from.first_name');
            if($request->has('message.text')){
                $this->normalizedData['command'] = $this->normalizedData['param']['command'] = str_replace("/", "", $request->input('message.text'));     
            } else {
                $this->normalizedData['command'] = $this->normalizedData['param']['command'] = 'start';
            }
        }

    }

    public function getData() : array{
        return $this->normalizedData;
    }
}