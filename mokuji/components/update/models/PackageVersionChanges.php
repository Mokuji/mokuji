<?php namespace components\update\models; if(!defined('TX')) die('No direct access.');

class PackageVersionChanges extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'update_package_version_changes',
    
    $relations = array(
      'PackageVersions' => array('package_version_id' => 'PackageVersions.id')
    );
  
  public function get_package_version()
  {
    
    return tx('Sql')
      ->table('update', 'PackageVersions')
      ->pk($this->package_version_id)
      ->execute_single();
    
  }
  
}
