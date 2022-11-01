<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Lib\ProductFactory;
use App\MyApiClient; // import using namespace

class TestController extends BaseController
{
    public function index()
    {
        //$product = ProductFactory::build('test', 1, 'test');
        //return $product->getType();

        return $this->test();
    }

    public function test()
    {
        return 1;
    }
}
