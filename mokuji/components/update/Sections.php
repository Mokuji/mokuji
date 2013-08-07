<?php namespace components\update; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'install_db' => 0,    //Uses INSTALLING constant for authorization
      'install_site' => 0,  //Uses INSTALLING constant for authorization
      'install_intro' => 0, //Uses INSTALLING constant for authorization
      'install_admin' => 0  //Uses INSTALLING constant for authorization
    );
  
  protected function install_intro($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //PHP_VERSION_ID is available as of PHP 5.2.7, if our version is lower than that, emulate it.
    if (!defined('PHP_VERSION_ID')) {
      $version = explode('.', PHP_VERSION);
      define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }
    
    $pdo_available = class_exists('\\PDO') &&
      in_array('mysql', \PDO::getAvailableDrivers());
    
    //Try using mysqli and mysql calls for client version.
    $mySqlVersion =
      function_exists('mysqli_get_client_info') ? explode('.', mysqli_get_client_info()) :
      function_exists('mysql_get_client_info') ? explode('.', @mysql_get_client_info()) :
      false;
    
    //If those fail but PDO + mysql is available, try using the default socket to get the client version.
    if($mySqlVersion === false && $pdo_available)
    {
      
      try{
        $pdo = new \PDO('mysql:');
        $mySqlVersion = explode('.', $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION));
        $pdo = null;
      }
      
      catch (\Exception $ex){
        //Best effort, I guess we don't have a proper setup here.
      }
      
    }
    
    return array(
      'requirements' => array(
        
        'PHP 5.3.8+' => array(
          'component' => 'Mokuji Core',
          'passed' => PHP_VERSION_ID >= 50308
        ),
        
        'PDO with MySQL driver' => array(
          'component' => 'Mokuji Core',
          'passed' => $pdo_available
        ),
        
        'MySQL 5.x client API' => array(
          'component' => 'Mokuji Core',
          'passed' => $mySqlVersion &&
            $mySqlVersion[0] >= 5
        )
        
      )
    );
    
  }
  
  protected function install_db($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //Include database config file if there is one and we don't have it included yet.
    if(file_exists(PATH_FRAMEWORK.DS.'config'.DS.'database'.EXT))
      require_once(PATH_FRAMEWORK.DS.'config'.DS.'database'.EXT);
    
    return array();
    
  }
  
  protected function install_site($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    //Include email config file if there is one and we don't have it included yet.
    if(file_exists(PATH_FRAMEWORK.DS.'config'.DS.'email'.EXT))
      require_once(PATH_FRAMEWORK.DS.'config'.DS.'email'.EXT);
    return array();
    
  }
  
  protected function install_admin($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('The CMS is not in install mode.');
    
    return array();
    
  }
  
}
