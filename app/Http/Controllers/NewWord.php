<?php

namespace App\Http\Controllers;

use App\Lib\Newwords\CambridgeParserLibrary;

class NewWord extends Controller{

    public function index(){
        $newCambridgeWord = NEW CambridgeParserLibrary();

        echo $word = $newCambridgeWord->getWordStatusZero();
        echo '<br/>';

        $pieces = explode(" ", trim($word));
        $example = $newCambridgeWord->GetExampleWordnikAPI($pieces[array_key_last($pieces)]);
        print_r($example);
        echo '<br/>';



        //print_r($newCambridgeWord->getNewWordObj());
        //return $newCambridgeWord->updateimg();
        //return $newCambridgeWord->saveNewWordInDb();
        //return $newCambridgeWord->getNewWordObj();
    }

}