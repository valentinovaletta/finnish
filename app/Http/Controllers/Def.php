<?php

namespace App\Http\Controllers;

use App\Services\DictionaryAPI\apiDictionaryapiDev;
use App\Models\EnDictionary;

class Def extends Controller{

    public function index(){
        
        $word = EnDictionary::where('ex', '')->first();

        $def = apiDictionaryapiDev::getDef( $word->first()->word, $word->first()->pos );
        //$ex = apiDictionaryapiDev::getEx( $word->first()->word );
        //$audio = apiDictionaryapiDev::getAudio( $word->first()->word );

        print_r($def);
        //print_r($audio);
    }

}