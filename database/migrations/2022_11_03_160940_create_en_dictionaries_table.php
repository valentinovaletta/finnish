<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('en_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->string('ts');
            $table->string('pos');
            $table->string('ex');
            $table->string('def');
            $table->string('audio');
            $table->string('img');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('en_dictionaries');
    }
}
