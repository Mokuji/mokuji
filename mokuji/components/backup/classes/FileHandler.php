<?php namespace components\backup\classes; if(!defined('MK')) die('No direct access.');

class FileHandler
{
  
  protected
    $handle;
  
  public function __construct($filename, $mode='a')
  {
    
    if(!is_dir(dirname($filename)))
      mkdir(dirname($filename));
    
    $this->handle = fopen($filename, $mode);
    
  }
  
  public function __destruct()
  {
    
    $this->close();
    
  }
  
  public function writeLine($input='')
  {
    
    $this->write($input.n);
    
  }
  
  public function write($input)
  {
    
    fwrite($this->handle, $input);
    
  }
  
  public function close()
  {
    
    if($this->handle && fclose($this->handle))
      $this->handle = null;
    
  }
  
}