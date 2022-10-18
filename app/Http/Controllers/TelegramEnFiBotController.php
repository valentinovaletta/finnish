<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class TelegramEnFiBotController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $token = '5773821899:AAGhBn9Vx4EDlOlsO_O4ceTncFYp0KCbUW8';

    private $id;
    private $message;

    public function index(Request $request) {
        $this->message = json_encode($request->all());
        $this->id = $request->input('message.from.id');

        Storage::disk('local')->put('log.txt', $this->message);

        return $this->TelegramApi('sendMessage', $this->id, ['text' => ($this->message)]);
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