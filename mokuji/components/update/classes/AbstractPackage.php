<?php namespace components\update\classes; if(!defined('MK')) die('No direct access.');

use \components\update\enums\PackageType;

abstract class AbstractPackage
{
  
  /**
   * Checks to see if package references are supported.
   * @return boolean
   */
  public static function reference_support()
  {
    
    try{
      $model = mk('Sql')
        ->table('update', 'Packages')
        ->where('reference_id', 'NULL')
        ->execute_single();
      return true;
    }
    catch(\exception\Sql $ex){
      mk('Logging')->log('AbstractPackage', 'Referencing', 'Detected reference support is not present. '.$ex->getMessage());
      return false;
    }
    
  }
  
  /**
   * A cached instance of the reference ID.
   * @var string
   */
  protected $reference_id;
  
  /**
   * A cached instance of the raw package data.
   * @var \dependencies\Data
   */
  protected $raw_data;
  
  /**
   * The type of package this instance refers to.
   * @var \components\update\enums\PackageType
   */
  protected $type;
  
  /**
   * The name of the package this instance refers to.
   * @var string
   */
  protected $name;
  
  /**
   * A cached instance of the model that refers to this package.
   * @var \components\update\models\Packages
   */
  protected $model;
  
  /**
   * Create a new instance.
   * @param \components\update\enums\PackageType $type The type of package the instance will refer to.
   * @param string $name The name of the package the instance will refer to.
   */
  public function __construct($type, $name=null)
  {
    
    //Store parameters.
    $this->type = $type;
    $this->name = $name;
    
  }
  
  /**
   * Update the update system information to match the package information.
   * @return boolean Whether or not syncing was completed successfully.
   */
  abstract public function synchronize();
  
  /**
   * Perform an update to the latest version of the package.
   * @param  boolean $forced     Forced update?
   * @param  boolean $allow_sync Syncing allowed?
   * @return boolean Whether or not new versions were installed.
   */
  abstract public function update($forced=false, $allow_sync=false);
  
  /**
   * Retrieves the reference ID of this package.
   * @return string The reference ID of this package.
   */
  abstract public function reference_id();
  
  /**
   * Gets the (absolute) base directory of this package.
   * @return string The base directory of this package.
   */
  abstract public function directory();
  
  /**
   * Retrieves the raw package data from the package files.
   * @return \dependencies\Data The raw package data.
   */
  abstract public function raw_data();
  
  /**
   * Retrieves the currently installed version of this package.
   * @return string The currently installed version of this package.
   */
  abstract public function current_version();
  
  /**
   * Retrieves the latest available version of this package.
   * @return string The latest available version of this package.
   */
  abstract public function latest_version();
  
  /**
   * Determines the next version that should be installed in the update order defined.
   * @param  string $version The version that is currently installed.
   * @return string The version that should be installed next.
   */
  abstract public function next_version($version=null);
  
  /**
   * Tracks a version update of the package.
   * Note: $allow_sync should only be set to true to allow the update component to install itself.
   * @param string $version The version of the package that is now installed.
   * @param boolean $allow_sync Whether or not to allow the package to be synced, to obtain version information.
   * @return boolean Whether or not the version update was successful.
   */
  abstract public function version_bump($version, $allow_sync=false);
  
  /**
   * Gets an instance of the DBUpdates class associated with this package, or null if not DBUpdates are used.
   * @return mixed The DBUpdates instance or null.
   */
  abstract public function db_updates();
  
  /**
   * Gets a model instance, referencing this package.
   * @return \components\update\models\Packages
   */
  abstract public function model();
  
}