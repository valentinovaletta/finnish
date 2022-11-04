<?php

namespace App\Lib\Newwords;

use App\Models\NewWords;
use App\Models\EnDictionary;

class CambridgeParserLibrary {

    private $id;
    private $word;
    private $part_of_speech;
    private $audio;
    private $difficulty;
    private $definition;
    private $examples;
    private $img;
    private $active = 0;
    private $CambridgeObj;

    public function __construct() {
        $this->word = $this->getWordFromDB(1);
        $this->img = $this->GetImgUnsplashApi($this->word);
        $this->CambridgeObj = $this->getMerriamWebsterApiDictionary($this->word);
    }

    private function getMerriamWebsterApiDictionary($word){
        $dictionaryJson = $this->CallDictionaryApi(urlencode("https://www.dictionaryapi.com/api/v3/references/collegiate/json/$word?key=90a34ae4-cc22-4bc5-a377-23e12ab74f00"));
        
        $this->part_of_speech = $dictionaryJson[0]['fl'];
        $this->definition = $dictionaryJson[0]['shortdef'][0];
        $this->examples = isset($dictionaryJson[0]['def'][0]['sseq'][0][0][1]['dt'][0][1]) ? $dictionaryJson[0]['def'][0]['sseq'][0][0][1]['dt'][0][1] : '';

        return $dictionaryJson[0];
    }

    public function getNewWordObj(){
        echo $this->word.'<br/>';
        echo '<img src="'.$this->img.'"></img><br/>';
        echo '<pre>';
        var_dump ($this->CambridgeObj);
        echo '</pre>';
        echo $this->part_of_speech.'<br/>';
        echo $this->definition.'<br/>';
        echo $this->examples.'<br/>';
    }
    public function saveNewWordInDb(){

        $q['word'] = $this->word;
        $q['part_of_speech'] = $this->part_of_speech;
        $q['audio'] = '';
        $q['difficulty'] = 1;
        $q['definition'] = "$this->definition";
        $q['examples'] = "$this->examples";
        $q['img'] = $this->img;
        $q['active'] = 1;

        Endictionary::insert($q);
        $this -> deleteFromNewWords($this->id);
    }
    private function getWordFromDB(){
        $newWord = NewWords::inRandomOrder()->limit(1)->get();
        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }

    private function deleteFromNewWords($ids){
        return NewWords::destroy($ids);
    }

    private function GetImgUnsplashApi($word){
        $UnsplashResponce = $this->CallDictionaryApi(urlencode("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&query=$word"));

        print_r( urlencode("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&query=$word") );

        print_r( $UnsplashResponce );

        // if( array_key_exists('results', $UnsplashResponce) && $UnsplashResponce['total'] > 0 ){
        //     $img = $UnsplashResponce['results'][0]['urls']['small'];
        // } else {
        //     $img = false;
        // }

        // return $img;
    }

    private function CallDictionaryApi($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
        return json_decode($resp, true);
    }

}