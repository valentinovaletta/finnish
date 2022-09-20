<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TelegramEnFiBotController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $token = '5495549584:AAF3AHevr_zFRqZX61kE7Atz2W2emIczquk';

    private $id;
    private $name;
    private $username;
    private $lang;

    private $text;
    private $menu;
    private $message;
    private $command;

    public function index(Request $request, $token){

        $this->message = json_encode($request->all());
        $this->id = $request->input('message.from.id');
        $this->name = $request->input('message.from.first_name');
        $this->username = $request->input('message.from.username');
        $this->lang = $request->input('message.from.language_code');

        $commandPos = strpos($request->input('message.text'), " "); 
        $this->command = $commandPos>0 ? strstr($request->input('message.text'), ' ', true) : $request->input('message.text');

        switch ($this->command) {
            case  '/start':
                $this->startMessage();
                break;        
            case  '/word':
                $this->wordMessage();
                break;                   
            case  '/repeat':
                $this->repeatMessage();
                break;      
            case  '/subscribe':
                $this->subscribeMessage();
                break;                                   
            default:
                $this->defaultMessage();
                break;
        }

        $keyboard = array(array("/word","/repeat","/restart"));
        $this->menu = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);

        return $this->TelegramApi('sendMessage',$this->id, ['text' => ($this->text), 'reply_markup' => json_encode($this->menu)]);   
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
