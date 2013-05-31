<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'blogposts_entry' => 0,
      'events_entry' => 0
    );
  
  protected function blogposts_entry($options)
  {
    
    return $options;
    
  }
  
  protected function events_entry($options)
  {
    return $options;
  }
  
}
