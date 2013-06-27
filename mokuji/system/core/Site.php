<?php namespace core; if(!defined('TX')) die('No direct access.');

class Site
{
  
  private
    $isLoaded = false,
    $actualSite = null;
  
  public function _load($site){
    
    if($this->isLoaded !== false)
      throw new \exception\Programmer('Site can only be set once during init phase.');
    
    if(!($site instanceof \stdClass))
      throw new \exception\Programmer('Site can only be set to an stdClass.');
    
    $this->actualSite = $site;
    $this->isLoaded = true;
    
  }
  
  public function __get($name){
    
    if($this->isLoaded === false)
      throw new \exception\Unexpected('Site has not been set during init phase.');
    
    if(!property_exists($this->actualSite, $name))
      throw new \exception\Programmer('Site has no property: '.$name);
    
    return $this->actualSite->{$name};
    
  }
  
}
