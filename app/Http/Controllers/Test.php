<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Test extends Controller{

    public function index(){

        $wordsSet = [];
        for($i=201; $i <= 300; $i++){
            $wordsSet[$i] = ['tag_id' => 3, 'word_id' => $i];
        }

        print_r( $wordsSet );
        DB::table('tag_words')->insert($wordsSet);

    }

}