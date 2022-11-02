<?php

namespace App\Lib\Message\Messages;

abstract class Message{
    abstract public function getText();
    abstract public function getMenu();
}