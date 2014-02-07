<?php namespace components\update; if(!defined('TX')) die('No direct access.');

use components\update\tasks\CoreUpdates;

class Sections extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      //Uses INSTALLING constant for authorization
      'upgrade_intro' => 0,
      'upgrade_config' => 0,
      'upgrade_files' => 0,
      'upgrade_packages' => 0,
      'install_db' => 0,
      'install_site' => 0,
      'install_intro' => 0,
      'install_admin' => 0
    );
  
  protected function upgrade_intro($data){
    return $this->install_intro($data);
  }
  
  protected function upgrade_config($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    $cores = CoreUpdates::detect_cores();
    
    //Include database config file from the new core, in case it's there.
    if(file_exists(PATH_FRAMEWORK.DS.'config'.DS.'database'.EXT))
      require_once(PATH_FRAMEWORK.DS.'config'.DS.'database'.EXT);
    
    //Otherwise fall back on the previous release.
    elseif(
      array_key_exists(CoreUpdates::CORE_ADEPT_ALBATROSS, $cores) &&
      file_exists(PATH_BASE.DS.'config'.DS.'database'.EXT)
    ) require_once(PATH_BASE.DS.'config'.DS.'database'.EXT);
    
    //Include email config file from the new core, in case it's there.
    if(file_exists(PATH_FRAMEWORK.DS.'config'.DS.'email'.EXT))
      require_once(PATH_FRAMEWORK.DS.'config'.DS.'email'.EXT);
    
    //Otherwise fall back on the previous release.
    elseif(
      array_key_exists(CoreUpdates::CORE_ADEPT_ALBATROSS, $cores) &&
      file_exists(PATH_BASE.DS.'config'.DS.'email'.EXT)
    ) require_once(PATH_BASE.DS.'config'.DS.'email'.EXT);
    
    return array();
    
  }
  
  protected function upgrade_files($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    return array();
    
  }
  
  protected function upgrade_packages($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    return array();
    
  }
  
  protected function upgrade_file_references($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    return array();
    
  }
  
  protected function install_intro($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    //PHP_VERSION_ID is available as of PHP 5.2.7, if our version is lower than that, emulate it.
    if (!defined('PHP_VERSION_ID')) {
      $version = explode('.', PHP_VERSION);
      define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }
    
    $pdo_available = class_exists('\\PDO') &&
      in_array('mysql', \PDO::getAvailableDrivers());
    
    //Try using mysqli and mysql calls for client version.
    $mySqlVersion =
      function_exists('mysqli_get_client_info') ? @mysqli_get_client_info() :
      function_exists('mysql_get_client_info') ? @mysql_get_client_info() :
      false;
    
    //If those fail but PDO + mysql is available, try using the default socket to get the client version.
    if($mySqlVersion === false && $pdo_available)
    {
      
      try{
        $pdo = new \PDO('mysql:');
        $mySqlVersion = $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION);
        $pdo = null;
      }
      
      catch (\Exception $ex){
        //Best effort, I guess we don't have a proper setup here.
      }
      
    }
    
    //Now that we've got a client version string, parse the version number.
    if($mySqlVersion){
      preg_match('~(\d+)\.(\d+)\.(\d+)~', $mySqlVersion, $mySqlVersion);
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
            $mySqlVersion[1] >= 5
        )
        
      )
    );
    
  }
  
  protected function install_db($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    //Include database config file if there is one and we don't have it included yet.
    if(file_exists(PATH_FRAMEWORK.DS.'config'.DS.'database'.EXT))
      require_once(PATH_FRAMEWORK.DS.'config'.DS.'database'.EXT);
    
    return array();
    
  }
  
  protected function install_site($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    //Include email config file if there is one and we don't have it included yet.
    if(file_exists(PATH_FRAMEWORK.DS.'config'.DS.'email'.EXT))
      require_once(PATH_FRAMEWORK.DS.'config'.DS.'email'.EXT);
    
    return array();
    
  }
  
  protected function install_admin($data)
  {
    
    if(INSTALLING !== true)
      throw new \exception\Authorisation('Mokuji is not in install mode.');
    
    return array();
    
  }
  
}
