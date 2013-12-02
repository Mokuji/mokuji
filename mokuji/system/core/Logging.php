<?php namespace core; if(!defined('TX')) die('No direct access.');

class Logging
{
  
  private 
    $logging_enabled;
  
  public function __construct()
  {
    
    //Use logging from the start when DEBUG is set to true.
    $this->logging_enabled = DEBUG;
    
  }
  
  public function set_logging_enabled($value)
  {
    
    raw($value);
    $this->logging_enabled = (bool)$value;
    
  }
  
  public function log()
  {
    
    //Get input.
    switch(func_num_args())
    {
      
      case 1:
        $key = null;
        $event = null;
        $message = func_get_arg(0);
        $newline = false;
        break;
      
      case 2:
        $key = func_get_arg(0);
        $event = null;
        $message = func_get_arg(1);
        $newline = false;
        break;
        
      case 3:
        $key = func_get_arg(0);
        $event = func_get_arg(1);
        $message = func_get_arg(2);
        $newline = false;
        break;
      
      case 4:
        $key = func_get_arg(0);
        $event = func_get_arg(1);
        $message = func_get_arg(2);
        $newline = func_get_arg(3);
        break;
      
      default:
        throw new \exception\Exception('Invalid use of log function. At least a message is required.');
      
    }
    
    //Check if we need to debug.
    if(!$this->logging_enabled)
      return;
    
    //Set output string.
    $data =
      
      //Prepend a newline?
      ($newline ? n : '').      
    
      //Date time prefix.
      date('Y-m-d H:i:s').' '.
      
      //No newlines for anything from the input.
      //Yes, this might not in all cases come out completely tidy, however it is only whitespace.
      str_replace(array("\r", "\r\n", "\n", "  "), '',
        
        //Key prefix.
        ($key === null ? '' : '['.$key.'] ').
        
        //Event prefix.
        ($event === null ? '' : '--'.$event.'-- ').
        
        //Message.
        $message
        
      ).//End replacing newlines.
      
      //Newline.
      n;
    
    //Write it to file.
    file_put_contents(PATH_LOGS.DS.date('Ymd').'.txlog', $data, FILE_APPEND);
    
  }
  
}
