<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use App\Lib\ILogger;

class TestController extends BaseController
{
    public function index(ILogger $logger,)
    {
        $logger->log("test");
    }
}