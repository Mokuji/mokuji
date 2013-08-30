<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class SiteDomains extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'core_site_domains',
  
    $relations = array(
      'Sites' => array('site_id' => 'Sites.id')
    );
  
  public function get_site()
  {
    
    return tx('Sql')
      ->table('cms', 'Sites')
      ->pk($this->site_id)
      ->execute_single();
    
  }
  
}
