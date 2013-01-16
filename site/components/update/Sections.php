<?php namespace components\update; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected function install_intro($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //PHP_VERSION_ID is available as of PHP 5.2.7, if our version is lower than that, emulate it.
    if (!defined('PHP_VERSION_ID')) {
      $version = explode('.', PHP_VERSION);
      define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }
    
    $mySqlVersion = function_exists('mysql_get_client_info') ? explode('.', mysql_get_client_info()) : false;
    
    return array(
      'requirements' => array(
        
        'PHP 5.3.8+' => array(
          'component' => 'Tuxion CMS Core',
          'passed' => PHP_VERSION_ID >= 50308
        ),
        
        'MySQL 5.0.3+' => array(
          'component' => 'Tuxion CMS Core',
          'passed' => $mySqlVersion &&
            $mySqlVersion[0] > 5 ||// 6+
            ($mySqlVersion[0] == 5 && $mySqlVersion[1] > 0) ||// 5.1+
            ($mySqlVersion[0] == 5 && $mySqlVersion[1] == 0 && $mySqlVersion[2] >= 3)// 5.0.3+
        )
        
      )
    );
    
  }
  
  protected function install_db($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //Include database config file if there is one and we don't have it included yet.
    if(file_exists(PATH_BASE.DS.'config'.DS.'database'.EXT))
      require_once(PATH_BASE.DS.'config'.DS.'database'.EXT);
    
    return array();
    
  }
  
  protected function install_site($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //Include email config file if there is one and we don't have it included yet.
    if(file_exists(PATH_BASE.DS.'config'.DS.'email'.EXT))
      require_once(PATH_BASE.DS.'config'.DS.'email'.EXT);
    return array();
    
  }
  
  protected function install_admin($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    return array();
    
  }
  
}
