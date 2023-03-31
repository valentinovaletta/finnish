<?php

namespace App\Services\DictionaryAPI;

class apiDictionaryapiDev {

    public static function getWord($word){
        return Self::Request( Self::getWordWithoutPrep($word) );
    }

    public static function getDefandEx($word, $pos){
        $request = json_decode(Self::Request( Self::getWordWithoutPrep($word) ), true);

        $def='';
        $ex='';

        if( !isset($request[0]['meanings']) ){
            return false;
        }

        foreach($request[0]['meanings'] as $meaning){
            if ( $meaning['partOfSpeech'] == $pos ){
                $def = isset($meaning['definitions'][0]['definition']) ? $meaning['definitions'][0]['definition'] : '';
                $ex = isset($meaning['definitions'][0]['example']) ? $meaning['definitions'][0]['example'] : '';
            }
        }

        return ['def' => $def, 'ex' => $ex];
    }   

    public static function getAudio($word){
        $request = json_decode(Self::Request( Self::getWordWithoutPrep($word) ), true);

        $audio = isset($request[0]['phonetics'][0]['audio']) ? $request[0]['phonetics'][0]['audio'] : '';
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