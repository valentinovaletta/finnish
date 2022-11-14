<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TagWord;

class Test extends Controller{

    private $id;

    public function index(){
        echo '<h1>TEST</h1>';
        $this->id = 494963311;

        //$wordIds = TagWord::where('tag_id', 5)->toSQL();
        $wordIds = TagWord::select('id', 'tag_id', 'word_id')
        ->where('tag_id', '=', '5')
        ->get();

        print_r($wordIds, true);

    }

}