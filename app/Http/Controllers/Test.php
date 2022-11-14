<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TagWord;

class Test extends Controller{

    private $id;

    public function index(){

        $this->id = 494963311;

        $wordIds = TagWord::where('tag_id', 5)->toSQL();
        print_r($wordIds, true);

    }

}