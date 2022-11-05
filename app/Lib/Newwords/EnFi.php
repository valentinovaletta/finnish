<?php

namespace App\Lib\Newwords;

use App\Models\EnDictionary;
use App\Models\FiDictionary;

class EnFi {

    private $id;
    private $word;

    public function __construct() {
        $this->word = $this->getWordFromDB(1);
        $this->getYandexApiDictionary( substr($this->word, 2) );
    }

    private function getYandexApiDictionary($word){
        $dictionaryJson = $this->CallDictionaryApi("https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=dict.1.1.20220605T165718Z.d29bca9ff5cc7d61.ae331150aaba52f73b5ad4d8bce3564ea9028917&lang=en-fi&text=".urlencode(trim($word)));
        
        $this->word = isset($dictionaryJson['def'][0]['tr'][0]['text']) ? $dictionaryJson['def'][0]['tr'][0]['text'] : '';

        //print_r( $dictionaryJson );

        return $dictionaryJson;
    }

    public function getNewWordObj(){
        echo $this->word.'<br/>';
    }
    public function saveNewWordInDb(){

        $q['id'] = $this->id;
        $q['word'] = $this->word;
        $q['ex'] = '';        
        $q['status'] = 1;

        Fidictionary::insert($q);
        $this -> deleteFromNewWords($this->id);
    }
    private function getWordFromDB(){
        $newWord = EnDictionary::inRandomOrder()->where('status', 0)->limit(1)->get();
        $this->id = $newWord->first()->id;        
        return $newWord->first()->word;
    }

    private function deleteFromNewWords($ids){
        return EnDictionary::where('id', $ids)->update(['status' => 1]);
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