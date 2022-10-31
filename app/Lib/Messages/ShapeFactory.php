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

  class CarFactory {
    protected $car;
    public function make($model=null){
      if(strtolower($model) == 'r'){
        return $this->car = new CarModelR();
      } else {
        return $this->car = new CarModelS();
      }
    }
  }

  interface Car {
    function getModel();
  }

  class CarModelS implements Car {
    protected $model = 's';
    
    public function getModel(){
      return $this->model;
    }
  }

  class CarModelR implements Car {
  protected $model = 'r';
  
  public function getModel(){
    return $this->model;
  }
}

$carOrder = new CarOrder;
var_dump($carOrder->getCarOrders());
 
$carOrder->order('r');
var_dump($carOrder->getCarOrders());
 
$carOrder->order('s');
var_dump($carOrder->getCarOrders());
