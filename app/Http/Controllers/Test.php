<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TagWord;

class Test extends Controller{

    private $id;

    public function index(){

        error_reporting(0);
        error_reporting(E_ALL);
        ini_set('error_reporting', E_ALL);

        echo '<h1>TEST</h1>';
        $this->id = 494963311;

        //$wordIds = TagWord::where('tag_id', 5)->toSQL();
        $wordIds = TagWord::select("word_id", DB::raw("0 as `points`") )
        ->where('tag_id', '5')
        ->get();

        $upsert = DB::table($this->id."_vocabulary")->upsert($wordIds->toArray(), []);

        var_dump($upsert, true);
    }

}