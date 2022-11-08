<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Test extends Controller{

    public function index(){

        $wordsSet = [];
        for($i=1; $i <= 400; $i++){
            $wordsSet[$i] = ['word_id' => $i, 'points' => 0];
        }

        print_r( $wordsSet );
        DB::table('494963311_vocabulary')->insert($wordsSet);

    }

}