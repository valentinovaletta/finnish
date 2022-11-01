<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Lib\Factory;

class TestController extends BaseController
{
    public function index()
    {
        $factory = new Factory();
        $product = $factory->create('Q');
        echo $product -> getName();
    }
}

