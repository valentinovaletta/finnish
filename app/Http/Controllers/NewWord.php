<?php

namespace App\Http\Controllers;

use App\Lib\Newwords\CambridgeParserLibrary;

class NewWord extends Controller{

    public function index(){
        $newCambridgeWord = NEW CambridgeParserLibrary();

        $word = $newCambridgeWord->getWordStatusZero();

        $pieces = explode(" ", trim($word));
        $example = $newCambridgeWord->GetExampleWordnikAPI($pieces[array_key_last($pieces)]);

        $def = strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",$example['def'])); 
        $ex = strip_tags(preg_replace("/&#?[a-z0-9]{2,8};/i","",$example['ex'])); 

        //dd($def,$ex);
        $newCambridgeWord->update('def', $def);
        $newCambridgeWord->update('ex', $ex);

        //print_r($newCambridgeWord->getNewWordObj());
        //return $newCambridgeWord->updateimg();
        //return $newCambridgeWord->saveNewWordInDb();
        //return $newCambridgeWord->getNewWordObj();
    }

}