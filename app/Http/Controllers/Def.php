<?php

namespace App\Http\Controllers;

use App\Services\TelegramAPI;
use App\Models\EnDictionary;

class Def extends Controller{

    public function index(){
        
        $word = EnDictionary::where('ex', '')->first();
        print_r($word);

    }

}