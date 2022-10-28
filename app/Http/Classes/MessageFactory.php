<?php

namespace App\Http\Classes;

class MessageFactory 
{
  public static function build($product_type)
  {
    $product = "Message_" . ucwords($product_type);
    if(class_exists($product)) {
      return new $product();
    } else {
      return new Message_Default();
    }
  }
}