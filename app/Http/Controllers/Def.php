<?php

namespace App\Http\Controllers;

use App\Services\DictionaryAPI\apiDictionaryapiDev;
use App\Models\EnDictionary;

class Def extends Controller{

    public function index(){
        
        $word = EnDictionary::where('ex', '')->limit(1)->get();

        $defAndEx = apiDictionaryapiDev::getDefandEx( $word->first()->word, $word->first()->pos );
        $audio = apiDictionaryapiDev::getAudio( $word->first()->word );

        return EnDictionary::where('id', $word->first()->id)
        ->update(['def' => $defAndEx['def'], 'ex' => $defAndEx['ex'], 'audio' => $audio]);
    }

}