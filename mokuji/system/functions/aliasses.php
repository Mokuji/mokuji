<?php if(!defined('TX')) die('No direct access.');

//backwards compatible alias
function tx()
{
  
  
  if(func_num_args() == 0 || is_null(func_get_arg(0))){
    return \dependencies\Superclass::get_instance();
  }
  
  elseif(func_num_args() == 2 && is_string(func_get_arg(0)) && (func_get_arg(1) instanceof \Closure)){
    return new \dependencies\UserFunction(func_get_arg(0), func_get_arg(1));
  }
  
  elseif(func_num_args() == 1 && (func_get_arg(0) instanceof \Closure)){
    return new \dependencies\UserFunction(null, func_get_arg(0));
  }
  
  else{
    $args = func_get_args();
    $class = array_shift($args);
    return \dependencies\Superclass::get_instance()->load_class($class, $args);
  }
  
  return false;
  
}

//return superobject or class within superobject
function mk()
{
  
  
  if(func_num_args() == 0 || is_null(func_get_arg(0))){
    return \dependencies\Superclass::get_instance();
  }
  
  elseif(func_num_args() == 2 && is_string(func_get_arg(0)) && (func_get_arg(1) instanceof \Closure)){
    return new \dependencies\UserFunction(func_get_arg(0), func_get_arg(1));
  }
  
  elseif(func_num_args() == 1 && (func_get_arg(0) instanceof \Closure)){
    return new \dependencies\UserFunction(null, func_get_arg(0));
  }
  
  else{
    $args = func_get_args();
    $class = array_shift($args);
    return \dependencies\Superclass::get_instance()->load_class($class, $args);
  }
  
  return false;
  
}