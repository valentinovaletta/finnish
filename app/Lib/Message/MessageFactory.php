<?php

namespace App\Lib\Message;

class MessageFactory implements IMessage
{
    public function getText($content)
    {
        echo "Log to DB $content";
    }
}