<?php

namespace App\Services\DictionaryAPI;

class apiDictionaryapiDev {

    public static function getWord($word){
        $ex = explode(" ", $word);
        return Self::Request($ex[1]);
    }

    public static function Request($word) {
        $url = "        https://api.dictionaryapi.dev/api/v2/entries/en/$word";
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