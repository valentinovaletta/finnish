<?php

namespace App\Lib\CreateImage;

use App\Models\EnDictionary;

class CreateImage {

    private $id;
    private $word;
    private $ex;

    public function __construct() {
        $this->word = $this->getWordFromDB();
        $this->ex = $this->getYandexApiDictionary($this->word);
    }

    private function getWordFromDB(){
        $newWord = EnDictionary::inRandomOrder()->where('status', 0)->limit(1)->get();
        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }

    public function show(){
        $data = [
            'id' => $this->id,
            'word' => $this->word,
            'ex' => $this->ex
        ];

        return $data;
    }

    public function saveNewWordInDb(){

        if( $this->ex != ''){
            Endictionary::where('id', $this->id)->update(['ex' => $this->ex, 'status' => 1]);
        }

    }

    private function getYandexApiDictionary($word){
        $dictionaryJson = $this->CallDictionaryApi("https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=dict.1.1.20220605T165718Z.d29bca9ff5cc7d61.ae331150aaba52f73b5ad4d8bce3564ea9028917&lang=en-ru&text=".urlencode(trim($word)));
        //print_r($dictionaryJson);
        return isset($dictionaryJson['def'][0]['tr'][0]['ex'][0]['text']) ? $dictionaryJson['def'][0]['tr'][0]['ex'][0]['text'] : '';
    }

    private function CallDictionaryApi($url){

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);
        curl_close($curl);
        return json_decode($resp, true);
    }
}