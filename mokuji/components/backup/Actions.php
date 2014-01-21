<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{
  
  protected function execute_profile($options)
  {
    
    $profile = mk('Sql')
      ->table('backup', 'Profiles')
      ->pk("'".$options->{0}->get('string')."'")
      ->execute_single()
      ->is('empty', function(){
        throw new \exception\NotFound('No profile with that name.');
      });
    
    $path = $this->helper('backup_database', $profile);
    echo 'Successfully executed backup.'.n;
    
  }
  
}
