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
    
        $unsplashImg = $this->GetImgUnsplashApi( $enWord->first()->word );

        if( $unsplashImg != '' ){
            $imgUrl = $unsplashImg;
        }

        $img = Image::make($imgUrl);

        $arraycolor = $img->pickColor(100, 100);
        $this->color = $this->rgb_best_contrast($arraycolor[0],$arraycolor[1],$arraycolor[2]);

        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->text($word, 100, 100, function($font) {
            $font->file(public_path('fonts/ubuntu.ttf'));
            $font->size(46);
            $font->color( $this->color );
            $font->align('center');
        });  
        $img->text($ruWord, 100, 150, function($font) {
            $font->file(public_path('fonts/ubuntu.ttf'));
            $font->size(46);
            $font->color( $this->color );
            $font->align('center');
        });        
        $img->text($ex, 100, 200, function($font) {
            $font->file(public_path('fonts/ubuntu.ttf'));
            $font->size(40);
            $font->color( $this->color );
            $font->align('center');
        });

        $img->save(public_path("images/$word.jpg"));  
    }

    private function rgb_best_contrast($r, $g, $b) {
        return array(
            ($r < 128) ? 255 : 0,
            ($g < 128) ? 255 : 0,
            ($b < 128) ? 255 : 0
        );
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
        $UnsplashResponce = $this->CallDictionaryApi("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&orientation=squarish&query=".$word);

        //print_r("https://api.unsplash.com/search/photos/?client_id=3d5fKAxk_gmo9I8XI20kCQWf0j0r1foLd6E7kuLaq0k&page=1&per_page=1&query=".$word);

        if( array_key_exists('results', $UnsplashResponce) && $UnsplashResponce['total'] > 0 ){
            $img = $UnsplashResponce['results'][0]['urls']['small'];
        } else {
            $img = false;
        }

        $img = str_replace("%body%", "black", "<body text='%body%'>");
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