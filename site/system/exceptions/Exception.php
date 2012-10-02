<?php namespace exception; if(!defined('TX')) die('No direct access.');

class Exception extends \Exception
{

  protected $prev; // thanks PHP...
  protected static $ex_code = EX_EXCEPTION;
  
  public function __construct()
  {
    
    $args = func_get_args();
    
    foreach($args as $k => $arg){
      if(is_array($arg)){
        $args[$k] = ul($arg);
      }
    }
    
    $message = call_user_func_array('sprintf', $args);
    
    parent::__construct($message);
    
  }
  
  public function setPrev(Exception $previous)
  {
    $this->prev = $previous;
  }
  
  public function getPrev()
  {
    return $this->prev;
  }
  
  public function getExCode()
  {
    return static::$ex_code;
  }
  
}