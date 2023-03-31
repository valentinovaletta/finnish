<?php

namespace App\Http\Controllers;

use App\Services\DictionaryAPI\apiDictionaryapiDev;
use App\Models\EnDictionary;

class Def extends Controller{

    public function index(){
        
        $word = EnDictionary::where('ex', '')->first();

        $def = apiDictionaryapiDev::getWord( $word->first()->word );

        print_r($def);
    }

}