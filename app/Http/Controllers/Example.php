<?php

namespace App\Http\Controllers;

use App\Lib\CreateImage\CreateImage;

class NewWord extends Controller{

    public function index(){
        $newCambridgeWord = NEW CreateImage();
        print_r($newCambridgeWord->show());
    }

}