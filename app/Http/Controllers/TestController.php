<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Lib\ProductFactory;
use App\Lib\MyApiClient; // import using namespace

class TestController extends BaseController
{
    public function index()
    {
        //$product = ProductFactory::build('test', 1, 'test');
        //return $product->getType();
        $foo = new MyApiClient;
        return $foo;
    }
}

