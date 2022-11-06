<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Test extends Controller{

    public function index(){

        $id = 12313123;

        Schema::connection('mysql')->create($id.'_vocabulary', function (Blueprint $table) {
            $table->integer('word_id')->primary()->unique();
            $table->integer('points');
            $table->timestamps();
        });

    }

}