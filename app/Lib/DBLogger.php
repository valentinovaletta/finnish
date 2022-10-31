<?php

namespace App\Lib;

class DBLogger implements ILogger
{
    public function log($content)
    {
        echo "Log to DB $content";
    }
}