<?php

namespace App\Lib\Message\Messages;
use Illuminate\Support\Facades\Artisan;

class MessageArtisan extends Message {

    private $id;
    private $param;

    private $text;

    public function __construct(int $id, array $param){
        $this->id = $id;
        $this->param = $param;

        //Artisan::call('migrate:refresh');
        
        $this->text = __('telegram.artisan', ['artisan' => Artisan::output()]);
    }

    public function getText(){
        return $this->text;
    }
}