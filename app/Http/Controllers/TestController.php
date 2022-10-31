<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use App\Lib\Logger;

class TestController extends BaseController
{
    public function index(Logger $logger,)
    {
        $logger->log("test");
    }
}