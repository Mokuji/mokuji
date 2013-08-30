<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Sites extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'core_sites',
  
    $relations = array(
      'Menus' => array('id' => 'Menus.site_id')
    );
  
  public function get_domains()
  {
    
    return tx('Sql')
      ->table('cms', 'SiteDomains')
      ->where('site_id', $this->id)
      ->execute();
    
  }
  
}
