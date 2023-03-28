<?php

namespace App\Services\TelegramAPI;

class TelegramAPI {

    private static $token;

    public function __construct() {
        self::$token = ENV('EnEnBotToken');
    }

    public static function Request($method, $param=[]) {
        $url = "https://api.telegram.org/bot".self::$token."/$method?";
        $url .= http_build_query($param);
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