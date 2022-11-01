<?php

namespace App\Lib\Message;

abstract class Message{
    abstract public function getText();
    abstract public function getMenu();
}