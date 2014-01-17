<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected function backup_profiles()
  {
    
    return array(
      'profiles' => mk('Sql')
        ->table('backup', 'Profiles')
        ->order('name')
        ->execute(),
      'backup_folder' => $this->helper('get_backup_folder')
    );
    
  }
  
}
