<?php

namespace App\Lib\CreateImage;

use App\Models\EnDictionary;
use Image;

class CreateImage {

    private $id;
    private $word;
    private $ex;

    private $color;

    public function __construct() {
        $this->word = $this->getWordFromDB();
        $this->ex = $this->getYandexApiDictionary( substr($this->word, 2) );
    }

    private function getWordFromDB(){
        $newWord = EnDictionary::inRandomOrder()->where('status', 0)->limit(1)->get();
        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }

    public function createImage(){
        $newWord = EnDictionary::inRandomOrder()->where('status', 1)->limit(1)->get();

        $word = $newWord->first()->word;
        $ts = $newWord->first()->ts;
        $pos = $newWord->first()->pos;
        $ex = $newWord->first()->ex;
        $imgUrl = $newWord->first()->img;
    
        $img = Image::make($imgUrl);

        $arraycolor = $img->pickColor(100, 100);
        $this->color = '#000';//$this->rgb_best_contrast($arraycolor[0],$arraycolor[1],$arraycolor[2]);

        $img->resize(null, 800, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->text($word, 200, 100, function($font) {
            $font->file(public_path('fonts/ubuntu.otf'));
            $font->size(76);
            $font->color( $this->color );
            $font->align('center');
        });  
        $img->text("[$ts] ($pos)", 200, 150, function($font) {
            $font->file(public_path('fonts/ubuntu.otf'));
            $font->size(56);
            $font->color( $this->color );
            $font->align('center');
        });
        $img->text($ex, 200, 200, function($font) {
            $font->file(public_path('fonts/ubuntu.otf'));
            $font->size(56);
            $font->color( $this->color );
            $font->align('center');
        });

        $img->resize(null, 800, function ($constraint) {
            $constraint->aspectRatio();
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