<?php

namespace App\Http\Controllers;

//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Foundation\Bus\DispatchesJobs;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class TelegramEnFiBotController extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $token = '5773821899:AAGhBn9Vx4EDlOlsO_O4ceTncFYp0KCbUW8';

    private $id;
    private $message;
    private $name;
    private $lang;
    private $command;

    private $text;
    private $menu;

    public function index(Request $request) {
        $this->message = json_encode($request->all());
        $this->id = $request->input('message.from.id');

        $this->name = $request->input('message.from.first_name');
        $this->lang = $request->input('message.from.language_code');
        $this->command = $request->input('message.text');

        Storage::disk('local')->put('log.txt', $this->message);

        switch ($this->command) {
            case  '/start':
                $this->startMessage();
                break;           
            default:
                $this->defaultMessage();
                break;
        }

        return $this->TelegramApi('sendMessage', $this->id, ['text' => ($this->text)], json_encode($this->menu));
    }

    private function defaultMessage(){
        $this->text = $this->message;
        $keyboard = array(array("/start","/info"));
        $this->menu = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);        
    }
    private function startMessage() {
        $this->text = "Hello! ". $this->name. " \r\nI'm a Finnish Language Bot. Nice to meet you!";
        $keyboard = array(array("/start","/info"));
        $this->menu = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
    }


    private function TelegramApi($method,$id,$param,$menu) {
        $url = "https://api.telegram.org/bot$this->token/$method?chat_id=".$id."&".http_build_query($param)."&reply_markup=".$menu;
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