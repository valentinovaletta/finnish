<?php

namespace App\Services\TelegramAPI;

class TelegramAPI {

    private $token;

    public function __construct() {
        $this->token = ENV('EnEnBotToken');
    }

    public static function Request($method, $token,$param=[]) {
        $url = "https://api.telegram.org/bot$token/$method?";
        echo $url .= http_build_query($param);
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