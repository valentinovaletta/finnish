<?php 

namespace App\Lib;

abstract class Product 
{
  private $sku;
  private $name;
  protected $type = null;
  
  public function __construct($sku, $name)
  {
    $this->sku = $sku;
    $this->name = $name;
  }
  
  public function getSku()
  {
    return $this->sku;
  }
  
  public function getName()
  {
    return $this->name;
  }
  
  public function getType()
  {
    return $this->type;
  }
}

class Product_Chair extends Product
{
  protected $type = 'chair';
}

class Product_Table extends Product
{
  protected $type = 'table';
}

class Product_Bookcase extends Product
{
  protected $type = 'bookcase';
}

class Product_Sofa extends Product
{
  protected $type = 'sofa';
}