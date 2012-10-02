<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

abstract class Successable
{
  
  private $success=null;
  
  // sets the success state to the boolean that is given, or returned by given callback
  public function is($check, $callback=null)
  {
    
    $check = $this->_do_check($check);
    
    if(is_callable($callback) && $check){
      $return = $callback($this);
      if(!is_null($return)) return Data($return);
    }
    
    else{
      $this->success = $check;
    }
    
    return $this;
    
  }
  
  // sets the success state to the opposite of what $this->is() would set it to with the same arguments
  public function not($check, $callback=null)
  {
    
    $check = $this->_do_check($check);
    
    if(is_callable($callback) && !$check){
      $return = $callback($this);
      if(!is_null($return)) return Data($return);
    }
    
    else{
      $this->success = !$check;
    }
    
    return $this;
    
  }
  
  // combines the current success state with what the new success state would be if is() would be called with the given arguments
  public function and_is($check, $callback=null)
  {
    
    if($this->success === false){
      return $this;
    }
    
    return $this->is($check, $callback);
    
  }
  
  // combines the current success state with what the new success state would be if not() would be called with the given arguments
  public function and_not($check)
  {
    
    if($this->success === false){
      return $this;
    }
    
    return $this->not($check);
    
  }
  
  // returns true, or executes $callback($this) if $this->success is true
  public function success($callback=null)
  {
  
    if(is_callable($callback)){
      if($this->success === true){
        $return = $callback($this);
        if(!is_null($return)) return Data($return);
      }
    }
    
    else{
      return $this->success;
    }
    
    return $this;
    
  }
  
  // returns true, or executes $callback($this) if $this->success is false
  public function failure($callback=null)
  {
    
    if(is_callable($callback)){
      if($this->success === false){
        $return = $callback($this);
        if(!is_null($return)) return Data($return);
      }
    }
    
    else{
      return !$this->success;
    }
    
    return $this;
    
  }
  
  // used internally to control success detection for actions in subnodes
  public function _success()
  {
    
    if(func_num_args() == 0){
      return $this->success;
    }
    
    $this->success = is_null(func_get_arg(0)) ? null : (bool) func_get_arg(0);
    return $this;
    
  }
  
  // convert given $check to boolean
  private function _do_check($check)
  {
    
    if($check instanceof \Closure){
      return (bool) $check($this);
    }
    
    elseif($check instanceof Successable){
      return $check->success() === true;
    }
    
    else{
      return (bool) $check;
    }
    
  }
  
}

