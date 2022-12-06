<?php

namespace App\Lib\CreateImage;

use App\Models\EnDictionary;
use App\Models\FiDictionary;

use Image;

class CreateImage {

    private $id;
    private $word;
    private $ex;

    private $color;

    public function __construct() {
    }

    private function getWordFromDB(){
        $newWord = EnDictionary::inRandomOrder()->where('status', 0)->limit(1)->get();
        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }

    public function createImage(){
        $enWord = EnDictionary::inRandomOrder()->where('status', 0)->limit(1)->get();
        $ruWord = FiDictionary::where('id', $enWord->first()->id )->get();

        $word = $enWord->first()->word;
        $ruWord = $ruWord->first()->word;
        $ts = $enWord->first()->ts;
        $pos = $enWord->first()->pos;
        $ex = $enWord->first()->ex;
        $imgUrl = $enWord->first()->img;

        $unsplashWord = explode(" ", $enWord->first()->word );
        $unsplashImg = trim($this->GetImgUnsplashApi( end($unsplashWord) ));

        if( $unsplashImg != '' ){
            $imgUrl = $unsplashImg;
        }
        $img = Image::make($imgUrl);

        $img->text($word, 10, 100, function($font) {
            $font->file(public_path('fonts/ubuntu.ttf'));
            $font->size(46);
            $font->color( '#fff' );
            $font->align('left');
        });  
        $img->text($ruWord, 10, 160, function($font) {
            $font->file(public_path('fonts/ubuntu.ttf'));
            $font->size(46);
            $font->color( '#fff' );
            $font->align('left');
        });        
        $img->text($ex, 10, 210, function($font) {
            $font->file(public_path('fonts/ubuntu.ttf'));
            $font->size(40);
            $font->color( '#fff' );
            $font->align('left');
        });

        $img->save(public_path("images/$word.jpg"));  
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
        Endictionary::where('id', $this->id)->update(['ex' => $this->ex, 'status' => 1]);
    }

    private function GetImgUnsplashApi($word){
        $UnsplashResponce = $this->CallDictionaryApi("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&orientation=squarish&color=black&query=".$word);

        //print_r("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&query=".$word);

        if( array_key_exists('results', $UnsplashResponce) && $UnsplashResponce['total'] > 0 ){
            $img = $UnsplashResponce['results'][0]['urls']['small'];
        } else {
            $img = false;
        }

        $img = str_replace("w=400", "w=800", $img);

        return $img;
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