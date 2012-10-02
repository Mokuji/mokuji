<?php namespace core; if(!defined('TX')) die('No direct access.');

class Config
{

  private
    $site,
    $system,
    $user;
  
  public function __construct()
  {
    
    $this->site = Data();
    $this->system = Data();
    $this->user = Data();
    
  }
  
  public function init()
  {
    
    // global $site_config, $system_config;
    // $this->config->push('site', $site_config)->push('system', $system_config);
    // unset($site_config, $system_config, $GLOBALS['site_config'], $GLOBALS['system_config']);
    
    if(INSTALLING !== true){
      foreach(tx('Sql')->execute_query('SELECT * FROM #__core_config WHERE autoload = 1 AND site_id = '.tx('Site')->id) AS $row){
        $this->user[$row->key] = $row->value;
      }
    }
    
    
  }
  
  public function site()
  {
    
    switch(func_num_args()){
      case 0: return $this->site;
      case 1: return $this->site[func_get_arg(0)];
      case 2: return $this->site[func_get_arg(0)]->set(func_get_arg(1));
    }
    
  }
  
  public function system()
  {
    
    switch(func_num_args()){
      case 0: return $this->system;
      case 1: return $this->system[func_get_arg(0)];
      case 2: return $this->system[func_get_arg(0)]->set(func_get_arg(1));
    }
    
  }
  
  public function user()
  {
    
    switch(func_num_args()){
      case 0: return $this->user;
      case 1: return $this->user[func_get_arg(0)];
      case 3: tx('Sql')->execute_non_query('UPDATE #__cms_config SET value = \''.mysql_real_escape_string(func_get_arg(1)).'\' WHERE key = \''.mysql_real_escape_string(func_get_arg(1)).'\'');
      case 2: return $this->user[func_get_arg(0)]->set(func_get_arg(1));
    }
    
  }
  
  public function cfg()
  {
    
    throw new \exception\Deprecated('Config::cfg() is deprecated.');
    
  }
  
}
