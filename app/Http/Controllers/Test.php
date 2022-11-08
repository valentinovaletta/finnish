<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Test extends Controller{

    public function index(){

        $wordsSet = [];
        for($i=1; $i <= 100; $i++){
            $wordsSet[$i] = ['tag_id' => 1, 'word_id' => $i];
        }

        print_r( $wordsSet );
        DB::table('tag_words')->insert($wordsSet);

    }

}