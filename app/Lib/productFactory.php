<?php

namespace App\Lib;

class ProductFactory 
{
  public static function build($product_type, $sku, $name)
  {
    $product = "Product_" . ucwords($product_type);
    if(class_exists($product))
    {
      return new $product($sku, $name);
    }
    else {
      throw new \Exception("Invalid product type given.");
    }
  }
}