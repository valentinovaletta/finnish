<?php

namespace App\Http\Controllers;

use App\Lib\Newwords\CambridgeParserLibrary;

class NewWord extends Controller{

    public function index(){
        $newCambridgeWord = NEW CambridgeParserLibrary();

        $word = $newCambridgeWord->getWordStatusZero();

        $pieces = explode(" ", trim($word));
        $example = htmlspecialchars($newCambridgeWord->GetExampleWordnikAPI($pieces[array_key_last($pieces)]));
        dd($example);
        //return $newCambridgeWord->update('ex', $example);

        //print_r($newCambridgeWord->getNewWordObj());
        //return $newCambridgeWord->updateimg();
        //return $newCambridgeWord->saveNewWordInDb();
        //return $newCambridgeWord->getNewWordObj();
    }

}