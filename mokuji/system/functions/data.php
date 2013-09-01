<?php if(!defined('TX')) die('No direct access.');

function string_if_empty(){
  
  $args = func_get_args();
  $data = array_shift($args);
  foreach($args as $arg){
    if($data->{$arg}->is_empty())
      $data->{$arg}->set('NULL');
  }
  return $data;
  
}

function string_if_null(){
  
  $args = func_get_args();
  $data = array_shift($args);
  foreach($args as $arg){
    if($data->{$arg}->get() === null)
      $data->{$arg}->set('NULL');
  }
  return $data;
  
};

function Data(){
  $arg = (func_num_args() == 1 ? func_get_arg(0) : (func_num_args() > 1 ? func_get_args() : null));
  return ($arg instanceof \dependencies\Data ? $arg : new \dependencies\Data($arg));
}

function is_data($data){
  return (is_object($data) && $data instanceof \dependencies\Data);
}

function data_of($data){
  return (is_data($data) ? ($data->is_leafnode() ? $data->get() : $data->as_array()) : $data);
}

function raw(&$v0, &$v1=null, &$v2=null, &$v3=null, &$v4=null, &$v5=null, &$v6=null, &$v7=null, &$v8=null, &$v9=null){
  
  if(func_num_args() > 10){
    throw new \exception\InvalidArguments('HAHA! You can only extract raw() values of 10 variables at a time.');
  }
  
  $v0 = data_of($v0);
  $v1 = data_of($v1);
  $v2 = data_of($v2);
  $v3 = data_of($v3);
  $v4 = data_of($v4);
  $v5 = data_of($v5);
  $v6 = data_of($v6);
  $v7 = data_of($v7);
  $v8 = data_of($v8);
  $v9 = data_of($v9);
  
}
