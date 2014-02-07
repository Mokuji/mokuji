<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class UserFunction extends Successable
{


  public 
    $exception=null,
    $action='performing an action',
    $return_value=null;
  
  public function __construct($action=null, \Closure $closure)
  {
    
    if(!is_null($action)){
      $this->action = strtolower(trim($action, ' .!?'));
    }
    
    try{
      $this->return_value = $closure();
    }
    
    catch(\exception\Expected $e)
    {
      
      tx('Logging')->log('UserFunction', 'Exception caught', $e->getMessage());
      
      $this->_success(false);
      $this->exception = $e;
      return;
    }
    
    $this->_success(true);
    
  }
  
  public function get_user_message($action=null)
  {
    
    if($this->success()){
      $message = '"%s" was successful';
    }
    
    else
    {
    
      switch($this->exception->getExCode())
      {
        
        case EX_AUTHORISATION:
          $message = 'Failed to authorise while %s: %s';
          break;
      
        case EX_VALIDATION:
          $message = 'Failed to validate while %s, because: %s';
          break;
      
        case EX_EMPTYRESULT:
          $message = 'Failed to load record needed for %s, because: %s';
          break;
      
        default: case EX_EXPECTED: case EX_USER:
          $message = 'Something went wrong while %s, because: %s';
          break;
          
      }
    
    }
    
    return ucfirst(sprintf(
      $message,
      (is_null($action) ? $this->action : strtolower(trim($action, ' .!?'))),
      ($this->exception instanceof \Exception ? ucfirst(strtolower(trim($this->exception->getMessage(), ' .!?'))) : 'No exception')
    )).'.';
  
  }
  
  public function failure($callback=null)
  {
    
    if($this->success() !== true)
      tx('Logging')->log('UserFunction', 'Exception handled');
    
    return parent::failure($callback);
    
  }
  
}
