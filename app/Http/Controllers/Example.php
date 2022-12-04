<?php

namespace App\Http\Controllers;

use App\Lib\CreateImage\CreateImage;

class Example extends Controller{

    public function index(){
        $newCambridgeWord = NEW CreateImage();
        print_r($newCambridgeWord->show());
        return $newCambridgeWord->saveNewWordInDb();
    }

}