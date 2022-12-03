<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;

class Test extends Controller{

    private $id;

    public function index(){

        error_reporting(0);
        error_reporting(E_ALL);
        ini_set('error_reporting', E_ALL);

        echo '<h1>TEST</h1>';
        $this->id = 494963311;

        $sets = Tag::leftJoin('tag_users', function($join) {
            $join->on('tags.id', '=', 'tag_users.tag_id')
            ->on('tag_users.user_id', '=', DB::raw($this->id));
          })
          ->whereNull('tag_users.tag_id')
          ->inRandomOrder()
          ->take(5)
          ->get();

        print_r($sets);  
// Select      t1.*
// From        tags t1
// Left Join   tag_users t2  On  t1.id = t2.tag_id And t2.user_id = 494963311
// Where       t2.tag_id Is Null

    }

}