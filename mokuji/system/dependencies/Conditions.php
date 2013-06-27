<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

class Conditions
{

  private
    $conditions = array(),
    $invoked = array(),
    $utilized = array();
  
  public function __invoke()
  {
    
    $this->invoked = func_get_args();
    return $this;
    
  }
  
  public function add($id, array $args)
  {
    
    if(!is_string($id)){
      throw new \exception\InvalidArgument('Expecting $id to be a string. %s given.', ucfirst(gettype($id)));
      return $this;
    }
    
    $condition = array(
      'type' => 'comparison'
    );
    
    switch(count($args))
    {
      
      case 0:
        return $this;
      
      case 1:
        $condition['column'] = key($args);
        $condition['value'] = current($args);
        $condition['comparitor'] = '=';
        break;
      
      case 2:
        $condition['column'] = $args[0];
        $condition['value'] = $args[1];
        $condition['comparitor'] = '=';
        break;
      
      case 3:
        $condition['column'] = $args[0];
        $condition['value'] = $args[2];
        $condition['comparitor'] = $args[1];
        break;
    
    }

    $this->conditions[$id] = $condition;
    
    return $this;
  
  }
  
  public function combine($id, array $ids, $connector='AND')
  {
    
    switch(count($ids))
    {
      
      case 1:
        return $this->add($id, $this->conditions[current($ids)], $connector);
        
      case 0:
        return $this;
        
    }
    
    $condition = array(
      'type' => 'combination',
      'connector' => $connector,
      'conditions' => $ids
    );
    
    $this->conditions[$id] = $condition;
    return $this;
    
  }
  
  public function utilize()
  {
    
    $this->utilized = func_get_args();
    return $this;
    
  }
  
  public function _get()
  {
  
    $keys = (count($this->invoked) > 0 ? $this->invoked : (count($this->utilized) > 0 ? $this->utilized : array_keys($this->conditions)));
    $array = array_intersect_key($this->conditions, array_fill_keys($keys, null));
    $this->invoked = array();
    return $this->to_array($array);
    
  }
  
  private function to_array($array)
  {
    
    $return = array();
    
    foreach($array as $key => $val)
    {
      
      if($val['type'] == 'combination'){
        $subarray = array_intersect_key($this->conditions, array_fill_keys($val['conditions'], null));
        $val['conditions'] = $this->to_array($subarray);
      }
      
      $return[$key] = $val;
      
    }
    
    return $return;
    
  }
  
}