<?php

namespace App\Services\EnEn\MessageFactory;

use App\Services\EnEn\MessageFactory\MessageDefault;
use App\Services\normalizeDataService\normalizeDataServiceInterface;

class MessageFactory {

    private $namespace = "App\Services\EnEn\MessageFactory\\";

    protected $method;
    protected $chatId;
    protected $command;
    protected $commandArg;
    protected $name;
    protected $param;
    protected $data;

    public function __construct(normalizeDataServiceInterface $telegramObject)
    {
      $this->data = $telegramObject->getData();
      //$this->method = $this->data['method'];
      $this->chatId = $this->data['chatId'];
      $this->command = $this->data['command'];
      $this->commandArg = $this->data['commandArg'];
      $this->name =  $this->data['name'];
      $this->param = $this->data['param'];
    }

    public function create() {

        $message = $this->namespace."Message".ucfirst($this->command);

        if(class_exists($message)){
          return new $message($this->chatId,$this->param);
        } else {
          return new MessageDefault($this->chatId, $this->param);
        }
    }

}