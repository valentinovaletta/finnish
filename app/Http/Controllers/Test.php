<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Test extends Controller{

    public function index(){

        $i = 0;
        $wordsSet = array_fill(1, 99, ['word_id' => $i++, 'points' => 0]);
        print_r( $wordsSet );
        //DB::table($this->id.'_vocabulary')->insert($wordsSet);

    }

}