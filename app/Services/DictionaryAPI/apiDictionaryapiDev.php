<?php

namespace App\Services\DictionaryAPI;

class apiDictionaryapiDev {

    public static function getWord($word){
        return Self::Request( Self::getWordWithoutPrep($word) );
    }

    public static function getDef($word){
        $request = json_decode(Self::Request( Self::getWordWithoutPrep($word) ), true);
        $def = '';

        if( !isset($request[0]['meanings']) ){
            return false;
        }

        foreach($request[0]['meanings'] as $meaning){
            $def .= $meaning['partOfSpeech'];
        }
        return $def;
    }

    public static function getEx($word){
        return Self::Request( Self::getWordWithoutPrep($word) );
    }    

    public static function getAudio($word){
        $request = json_decode(Self::Request( Self::getWordWithoutPrep($word) ), true);

        $audio = isset($request[0]['phonetics'][0]['audio']) ? $request[0]['phonetics'][0]['audio'] : false;
        return $audio;
    }     

    private static function getWordWithoutPrep($word) {
        $ex = explode(" ", $word);
        return $ex[1];
    }

    private static function Request($word) {
        $url = "https://api.dictionaryapi.dev/api/v2/entries/en/$word";
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