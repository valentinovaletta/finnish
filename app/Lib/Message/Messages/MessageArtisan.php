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

        //Artisan::call('migrate', ['--force' => true,]);
        Artisan::call('migrate:refresh');
        //Artisan::call('db:seed');

        $this->text = "Hello!\r\nThis is an Artisan message!\r\n".Artisan::output();
    }

    public function getText(){
        return $this->text;
    }
}