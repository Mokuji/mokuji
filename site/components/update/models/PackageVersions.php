<?php namespace components\update\models; if(!defined('TX')) die('No direct access.');

class PackageVersions extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'update_package_versions',
    
    $relations = array(
      'Packages' => array('package_id' => 'Packages.id'),
      'PackageVersionChanges' => array('id' => 'PackageVersionChanges.package_version_id')
    );
  
  public function get_package()
  {
    
    return tx('Sql')
      ->table('update', 'Packages')
      ->pk($this->package_id)
      ->execute_single();
    
  }
  
  public function get_changes()
  {
    
    return tx('Sql')
      ->table('update', 'PackageVersionChanges')
      ->where('package_version_id', $this->id)
      ->execute();
    
  }
  
}
