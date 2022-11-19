<?php

namespace App\Lib\Message\Messages;

abstract class Message{

    abstract public function __construct(int $id, array $param);

    abstract public function getText();

}