<?php

namespace App\Http\Controllers;

use App\Services\DictionaryAPI\apiDictionaryapiDev;
use App\Models\EnDictionary;

class Def extends Controller{

    public function index(){
        
        $word = EnDictionary::where('ex', '')->first();

        $defAndEx = apiDictionaryapiDev::getDefandEx( $word->first()->word, $word->first()->pos );
        //$ex = apiDictionaryapiDev::getEx( $word->first()->word );
        //$audio = apiDictionaryapiDev::getAudio( $word->first()->word );

        print_r($defAndEx);
        //print_r($audio);
    }

}