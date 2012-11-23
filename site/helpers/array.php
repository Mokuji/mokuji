<?php if(!defined('TX')) die('No direct access.');
  
  
  /**
  *
  * Searches for a given value and returns a disasociative array of corresponding keys
  *  array_search_recursive('bye', array('a'=>array('hi'=>'bye', 'nyerk'), 'b'=>array(1, '2'=>'nyerk')))
  *  Returns: array(0=>'a', 1=>'hi')
  *  
  *  Only the corresponding keys of the first instance of values are returned
  *   array_search_recursive('nyerk', array('a'=>array('hi'=>'bye', 'nyerk'), 'b'=>array(1, '2'=>'nyerk')))
  *   Returns: array(0=>'a')
  *
  *  False is returned when no matches are found
  *   array_search_recursive('blerp', array('a'=>array('hi'=>'bye', 'nyerk'), 'b'=>array(1, '2'=>'nyerk')))
  *   Returns: false
  *
  */
  
  function array_search_recursive($needle, array $haystack, $offset_depth = 0, $strict = false, $depth = 0, $keys = array())
  {

    $size = count($keys);
    
    foreach($haystack AS $key => $val)
    {
      if(is_array($val))
      {
        $keys[$depth] = $key;
        $sub = array_search_recursive($needle, $val, $offset_depth, $strict, ($depth+1), $keys);
        if($sub === false){
          $keys = array();
          continue;
        }else{
          $keys = $sub;
          break;
        }
      }
      
      else
      {
        if(($strict === true ? ($val === $needle) : ($val == $needle)) && ($depth >= $offset_depth)){
          $keys[$depth] = $key;
          break;
        }
      }
    }
    
    return ((count($keys) > $size) ? $keys : false);
    
  }
  
  function array_merge_recursive_distinct()
  {
    $arrays = func_get_args();
    $base = array_shift($arrays);
    
    if(!is_array($base)){
      $base = (empty($base) ? array() : array($base));
    }
    
    foreach($arrays as $append)
    {
      
      if(!is_array($append)){
        $append = array($append);
      }
      
      foreach($append as $key => $value)
      {
        
        if(!array_key_exists($key, $base) and !is_numeric($key)) {
          $base[$key] = $append[$key];
          continue;
        }
        
        if(is_array($value) and is_array($base[$key])){
          $base[$key] = array_merge_recursive_distinct($base[$key], $append[$key]);
        }
        
        elseif(is_null($value)){
          unset($base[$key]);
        }
        
        else{
          $base[$key] = $value;
        }
        
      }
      
    }
    return $base;
  }
  
  function array_get()
  {
    
    $arguments = func_get_args();
    $array = array_shift($arguments);
    $num = count($arguments);
    $i = 0;
    $subject = $array;
    
    do
    {
      
      if(!is_array($subject)){
        throw new \exception\InvalidArgument('Subject is not an array.');
        return false;
      }
      
      if(!array_key_exists($arguments[$i], $subject)){
        return null;
      }
      
      $subject = $subject[$arguments[$i]];
      $i++;
      
    }
    while($i < $num);
    
    return $subject;
  
  }
  
  function array_try(array $array, $key, $else)
  {
    
    return array_key_exists($key, $array) ? $array[$key] : $else;
    
  }
  
  function array_flatten(array $array)
  {
  
    $return = array();
    
    array_walk_recursive($array, function($a)use(&$return){
      $return[] = $a;
    });
    
    return $return;
    
  }
  
  function implode_keys($delimitter, $separator, array $array)
  {
    
    $implode = '';
    
    for($i=1, $size = count($array), reset($array); list($key, $value) = each($array), $i <= $size; $i++){
      $implode .= "$key$separator$value".($i<$size?$delimitter:'');
    }
    
    return $implode;
    
  }
