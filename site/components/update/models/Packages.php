<?php namespace components\update\models; if(!defined('TX')) die('No direct access.');

class Packages extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'update_packages',
    
    $relations = array(
      'PackageVersions' => array('id' => 'PackageVersions.package_id')
    );
  
  public function get_versions()
  {
    
    return tx('Sql')
      ->table('update', 'PackageVersions')
      ->where('package_id', $this->id)
      ->order('date', 'DESC')
      ->execute();
    
  }
  
}
