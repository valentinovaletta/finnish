<?php

namespace App\Lib\Newwords;

use Illuminate\Support\Facades\DB;

use App\Models\NewWords;
use App\Models\EnDictionary;

class CambridgeParserLibrary {

    private $id;
    private $word;
    private $part_of_speech;
    private $ts;
    private $audio;
    private $difficulty;
    private $definition;
    private $examples;
    private $img;
    private $active = 0;
    private $CambridgeObj;

    public function __construct() {
        //$this->word = $this->getWordFromDB(1); // regular word
        $this->word = $this->getWordFromDBwithoutImg(1); // without image
        $this->img = $this->GetImgPexelsApi( urlencode(trim($this->word)) );
        //$this->img = $this->GetImgUnsplashApi( substr($this->word, -2) ); // substr($this->word, 2)
        //$this->CambridgeObj = $this->getYandexApiDictionary( $this->word ); // substr($this->word, 2)
    }

    private function getMerriamWebsterApiDictionary($word){
        $dictionaryJson = $this->CallDictionaryApi("https://www.dictionaryapi.com/api/v3/references/collegiate/json/$word?key=90a34ae4-cc22-4bc5-a377-23e12ab74f00");
        
        $this->part_of_speech = isset($dictionaryJson[0]['fl']) ? $dictionaryJson[0]['fl'] : '';
        $this->definition = isset($dictionaryJson[0]['shortdef'][0]) ? $dictionaryJson[0]['shortdef'][0] : '';
        $this->examples = isset($dictionaryJson[0]['def'][0]['sseq'][0][0][1]['dt'][0][1]) ? $dictionaryJson[0]['def'][0]['sseq'][0][0][1]['dt'][0][1] : '';

        return $dictionaryJson[0];
    }

    private function getYandexApiDictionary($word){
        $dictionaryJson = $this->CallDictionaryApi("https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=dict.1.1.20220605T165718Z.d29bca9ff5cc7d61.ae331150aaba52f73b5ad4d8bce3564ea9028917&lang=en-en&text=".urlencode(trim($word)));
        
        $this->part_of_speech = isset($dictionaryJson['def'][0]['pos']) ? $dictionaryJson['def'][0]['pos'] : '';
        $this->ts = isset($dictionaryJson['def'][0]['ts']) ? $dictionaryJson['def'][0]['ts'] : '';
        $this->definition = isset($dictionaryJson['def'][0]['tr'][0]['text']) ? $dictionaryJson['def'][0]['tr'][0]['text'] : '';

        //print_r( $dictionaryJson );

        return $dictionaryJson;
    }

    public function getNewWordObj(){
        echo $this->id.'<br/>';
        echo $this->word.'<br/>';
        echo '<img src="'.$this->img.'"></img><br/>';
        // echo '<pre>';
        // var_dump ($this->CambridgeObj);
        // echo '</pre>';
        echo $this->part_of_speech.'<br/>';
        echo $this->definition.'<br/>';
        echo $this->ts.'<br/>';
    }
    public function saveNewWordInDb(){
        $q['word'] = $this->word;
        $q['pos'] = $this->part_of_speech;
        $q['ts'] = $this->ts;
        $q['ex'] = "$this->examples";
        $q['img'] = $this->img;
        $q['status'] = 0;
        Endictionary::insert($q);
        $this -> deleteFromNewWords($this->id);
    }
    
    private function getWordFromDB(){
        $newWord = NewWords::inRandomOrder()->where('status', 0)->limit(1)->get();
        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }

    private function getWordFromDBwithoutImg(){
        $newWord = DB::table('en_dictionaries')
        ->where('status', '=', 0)
        ->limit(1)
        ->get();

        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }
    public function updateimg(){
        Endictionary::where('id', $this->id)->update(['img' => $this->img, 'status' => 1]);
    }

    private function deleteFromNewWords($ids){
        return NewWords::where('id', $ids)->update(['status' => 1]);
    }

    private function GetImgUnsplashApi($word){
        $UnsplashResponce = $this->CallDictionaryApi("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&query=".urlencode(trim($word)));

        //print_r("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&query=".urlencode(trim($word)));

        if( array_key_exists('results', $UnsplashResponce) && $UnsplashResponce['total'] > 0 ){
            $img = $UnsplashResponce['results'][0]['urls']['small'];
        } else {
            $img = false;
        }

        return $img;
    }

    private function GetImgPexelsApi($word){

        $url = "https://api.pexels.com/v1/search?query=to+stop&per_page=11";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
           "Authorization: 563492ad6f91700001000001b45ded94511842c3bda5fa180f0c9e18",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        var_dump($resp);



        //$UnsplashResponce = $this->CallDictionaryApi("https://api.pexels.com/v1/search?query=$word&per_page=1");
        //echo "https://api.pexels.com/v1/search?query=$word&per_page=1";
        //return $img;
    }

    private function CallDictionaryApi($url){

        $headers = array(
            "Authorization: 563492ad6f91700001000001b45ded94511842c3bda5fa180f0c9e18",
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        var_dump($resp);
        return json_decode($resp, true);
    }

}