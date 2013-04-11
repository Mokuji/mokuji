<?php

function __autoload($class)
{
  
  $class_array = explode('\\', $class);
  
  if(count($class_array) == 1){
    require_once(__DIR__.'/'.str_replace('_', '/', $class).'.php');
  }
  
  else{
    require_once(__DIR__.'/'.implode('/',$class_array).'.php');
  }
  
  return $class;
  
}
