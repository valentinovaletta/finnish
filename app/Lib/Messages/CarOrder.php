<?php

namespace app\Lib\Messages;

class CarOrder {
    protected $carOrders = array();
    protected $car;
    public function __construct(){
      $this->car = new CarFactory();
    }
    
    public function order($model=null){
      $car = $this->car->make($model);
      $this->carOrders[]=$car->getModel();
    }
    
    public function getCarOrders(){
      return $this->carOrders;
    }
  }