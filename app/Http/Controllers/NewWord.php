<?php

namespace App\Http\Controllers;

use App\Lib\Newwords\CambridgeParserLibrary;

class NewWord extends Controller{

    public function index(){
        $newCambridgeWord = NEW CambridgeParserLibrary();
        print_r($newCambridgeWord->getNewWordObj());
        return $newCambridgeWord->updateimg();
        //return $newCambridgeWord->saveNewWordInDb();
        //return $newCambridgeWord->getNewWordObj();
    }

}