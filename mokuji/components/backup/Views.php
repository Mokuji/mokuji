<?php namespace components\backup; if(!defined('MK')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected function backup_profiles()
  {
    
    $folder = $this->helper('get_backup_folder');
    $space = null;
    
    //Best effort.
    try{
      $space = sprintf('%1.2f', disk_free_space($folder) / (pow(1024, 3)));
    }catch(\Exception $e){}
    
    return array(
      'profiles' => mk('Sql')
        ->table('backup', 'Profiles')
        ->order('name')
        ->execute(),
      'backup_folder' => $folder,
      'free_space' => $space
    );
    
  }
  
}
