<?php namespace components\update; if(!defined('TX')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'finalize_install' => 0 //Uses INSTALLING constant for authorization
    );
  
  protected function check_updates($options)
  {
    
    tx('Component')->helpers('update')->call('check_updates', $options);
    
  }
  
  protected function finalize_install($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //Mark the fact the installation is done.
    file_put_contents(PATH_BASE.DS.'install'.DS.'.completed', '');
    
    tx('Url')->redirect('/admin/');
    
  }
  
}
