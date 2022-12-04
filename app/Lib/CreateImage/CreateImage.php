<?php

namespace App\Lib\CreateImage;

use App\Models\EnDictionary;

class CreateImage {

    private $id;
    private $word;

    public function __construct() {
        $this->word = $this->getWordFromDB();
    }

    private function getWordFromDB(){
        $newWord = EnDictionary::inRandomOrder()->where('status', 0)->limit(1)->get();
        $this->id = $newWord->first()->id;
        return $newWord->first()->word;
    }

    public function show(){
        $data = [
            'id' => $this->id,
            'word' => $this->word
        ];

        return $data;
    }

}