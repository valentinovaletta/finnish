<?php

namespace App\Lib;

interface ILogger
{
    public function log($content);
}

class FileLogger implements ILogger
{
    public function log($content)
    {
        echo "Log to File";
    }
}

class CloudLogger implements ILogger
{
    public function log($content)
    {
        echo "Log to Cloud";
    }
}