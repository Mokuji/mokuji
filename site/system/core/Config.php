<?php namespace core; if(!defined('TX')) die('No direct access.');

/**
 * Provides core features to manage and access configuration variables.
 */
class Config
{
  
  /**
   * Holds site related configuration variables.
   */
  private $site;
  
  /**
   * Holds system related configuration variables.
   */
  private $system;
  
  /**
   * Holds user configured configuration variables.
   */
  private $user;
  
  /**
   * Initializes the class.
   */
  public function __construct()
  {
    
    $this->site = Data();
    $this->system = Data();
    $this->user = Data();
    
  }
  
  /**
   * When we're not in the installation environment, loads user configuration from the database.
   */
  public function init()
  {
    
    //Do nothing when installing.
    if(INSTALLING === true){
      return;
    }
    
    //Try to get values from the database with a language ID.
    try
    {
      
      //Get the default values.
      $result = tx('Sql')->execute_query('
        SELECT * FROM #__core_config
        WHERE autoload = 1 AND language_id IS NULL AND site_id = '.tx('Site')->id
      );
      
      //Apply default values.
      foreach($result AS $row){
        $this->user[$row->key] = $row->value;
      }
      
      //Get all language specific items to overwrite it with.
      $result = tx('Sql')->execute_query('
        SELECT * FROM #__core_config
        WHERE 1
          AND autoload = 1
          AND value IS NOT NULL
          AND language_id = '.tx('Language')->id.'
          AND site_id = '.tx('Site')->id
      );
      
      //Apply specific values.
      foreach($result AS $row){
        $this->user[$row->key] = $row->value;
      }
      
    }
    
    //If something went wrong, we will try the old way: Without a language_id.
    catch(\exception\Sql $e)
    {
      
      //Get values from the database.
      $result = tx('Sql')->execute_query('
        SELECT * FROM #__core_config
        WHERE autoload = 1 AND site_id = '.tx('Site')->id
      );
      
      //Apply values.
      $this->user->merge($result);
      
    }
    
  }
  
  /**
   * Gets or sets site related configuration variables.
   *
   * Usage:
   *   0 params returns Data of all configuration variables.
   *   1 param: String $key The key for the variable to get.
   *   2 params: String $key The key of the variable to set. mixed $val The value to set.
   */
  public function site()
  {
    
    switch(func_num_args()){
      case 0: return $this->site;
      case 1: return $this->site[func_get_arg(0)];
      case 2: return $this->site[func_get_arg(0)]->set(func_get_arg(1));
    }
    
  }
  
  /**
   * Gets or sets system related configuration variables.
   *
   * Usage:
   *   0 params returns Data of all configuration variables.
   *   1 param: String $key The key for the variable to get.
   *   2 params: String $key The key of the variable to set. mixed $val The value to set.
   */
  public function system()
  {
    
    switch(func_num_args()){
      case 0: return $this->system;
      case 1: return $this->system[func_get_arg(0)];
      case 2: return $this->system[func_get_arg(0)]->set(func_get_arg(1));
    }
    
  }
  
  /**
   * Gets or sets user configured configuration variables.
   *
   * Usage:
   *   0 params returns Data of all configuration variables.
   *   1 param: String $key The key for the variable to get.
   *   2 params: String $key The key of the variable to set. mixed $val The value to set.
   *   3 params: String $key The key of the variable to set. mixed $val The value to set. int $lang The optional language ID for which to store the value in the database.
   */
  public function user()
  {
    
    switch(func_num_args()){
      case 0: return $this->user;
      case 1: return $this->user[func_get_arg(0)];
      case 3: 
        $val = mysql_real_escape_string(func_get_arg(1));
        $key = mysql_real_escape_string(func_get_arg(0));
        $lid = func_get_arg(2) ? mysql_real_escape_string(func_get_arg(2)) : null;
        $lidWhere = '`language_id` ' . ($lid ? "= '$lid'" : 'IS NULL');
        tx('Sql')->execute_non_query("UPDATE #__core_config SET `value` = '$val' WHERE `site_id` = '".tx('Site')->id."' AND `key` = '$key' AND $lidWhere");
      case 2: return $this->user[func_get_arg(0)]->set(func_get_arg(1));
    }
    
  }
  
}
