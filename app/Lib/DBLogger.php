<?php

namespace App\Lib;
use App\Lib\ILogger;

class DBLogger implements ILogger
{
    public function log($content)
    {
        echo "Log to DB";
    }
}