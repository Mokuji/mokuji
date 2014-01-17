<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected function get_execute_profile($options, $sub_routes)
  {
    
    return array(
      'path' => $this->helper('backup_database', mk('Sql')->table('backup', 'Profiles')->pk("'".$sub_routes->{0}."'")->execute_single())
    );
    
  }
  
}
