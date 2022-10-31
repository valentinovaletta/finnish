<?php

namespace App\Lib;

interface ILogger
{
    public function log($content);
}

class DBLogger implements ILogger
{
    public function log($content)
    {
        echo "Log to DB";
    }
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