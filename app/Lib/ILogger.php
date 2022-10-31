<?php

namespace App\Lib;

interface Logger
{
    public function log($content);
}

class DBLogger implements Logger
{
    public function log($content)
    {
        echo "Log to DB";
    }
}

class FileLogger implements Logger
{
    public function log($content)
    {
        echo "Log to File";
    }
}

class CloudLogger implements Logger
{
    public function log($content)
    {
        echo "Log to Cloud";
    }
}