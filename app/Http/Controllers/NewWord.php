<?php

namespace App\Http\Controllers;

use App\Lib\Newwords\CambridgeParserLibrary;

class NewWord extends Controller{

    public function index(){
        $newCambridgeWord = NEW CambridgeParserLibrary();

        $word = $newCambridgeWord->getWordStatusZero();

        $pieces = explode(" ", trim($word));
        $example = $newCambridgeWord->GetExampleWordnikAPI($pieces[array_key_last($pieces)]);

        $def = preg_replace("/&#?[a-z0-9]{2,8};/i","",$example['def']); 
        $ex = preg_replace("/&#?[a-z0-9]{2,8};/i","",$example['ex']); 

        dd($def,$ex);
        //return $newCambridgeWord->update('ex', $example);

        //print_r($newCambridgeWord->getNewWordObj());
        //return $newCambridgeWord->updateimg();
        //return $newCambridgeWord->saveNewWordInDb();
        //return $newCambridgeWord->getNewWordObj();
    }

}