<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use App\Lib\Message\MessageFactory;

class TelegramEnFiBotController extends BaseController
{
    private $token = '5773821899:AAGhBn9Vx4EDlOlsO_O4ceTncFYp0KCbUW8';

    private $id;
    private $message;
    private $name;
    private $lang;
    private $command;

    private $text;
    private $menu = array("keyboard" => array(array("/start","/info")),"resize_keyboard" => true,"one_time_keyboard" => true);


    public function index(Request $request) {
        $this->message = json_encode($request->all());
        $this->id = $request->input('message.from.id');

        $this->name = $request->input('message.from.first_name');
        $this->lang = $request->input('message.from.language_code');
        $this->command = $request->input('message.text');

        Storage::disk('local')->put('log.txt', $this->message);

        $messageFactory = new MessageFactory();
        $message = $messageFactory->create(type: str_replace("/", "", $this->command), id: $this->id, param: ['name' => $this->name, 'lang' => $this->lang] );
        $this->text = $message -> getText();

        return $this->TelegramApi('sendMessage', $this->id, ['text' => ($this->text), 'reply_markup' => json_encode($this->menu)]);
    }

    private function TelegramApi($method,$id,$param) {
        $url = "https://api.telegram.org/bot$this->token/$method?chat_id=".$id."&".http_build_query($param);
        $ch = curl_init();
        $optArray = array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
     
}