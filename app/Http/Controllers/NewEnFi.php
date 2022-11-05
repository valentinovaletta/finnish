<?php

namespace App\Http\Controllers;

use App\Lib\Newwords\EnFi;

class NewEnFi extends Controller{

    public function index(){
        $newCambridgeWord = NEW EnFi();
        print_r($newCambridgeWord->getNewWordObj());
        return $newCambridgeWord->saveNewWordInDb();
        //return $newCambridgeWord->getNewWordObj();
    }

}