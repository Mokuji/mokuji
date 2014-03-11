<?php namespace components\update\packages; if(!defined('MK')) die('No direct access.');

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
   * Gets the (absolute) base directory of this package.
   * @return string The base directory of this package.
   */
  public function directory(){
    return PackageFactory::directory($this->type, $this->name);
  }
  
  /**
   * Retrieves the latest available version of this package.
   * @return string The latest available version of this package.
   */
  public function latest_version()
  {
    
    //Try our cache first.
    if(isset($this->latest_version))
      return $this->latest_version;
    
    //Find the latest version.
    $latest = Data();
    
    //Go over each version.
    $this->raw_data()->versions->each(function($version)use(&$latest){
      
      //Bump latest version if needed.
      $version->timestamp->set(strtotime($version->date->get()));
      if($version->timestamp->get() > $latest->timestamp->get())
        $latest = $version;
      
      //The timestamps are the same, try and parse the version name to see which one is more recent.
      elseif($version->timestamp->get() == $latest->timestamp->get()){
        
        if(
          preg_match('~^(\d+)\.(\d+)\.(\d+)-(stable|beta|alpha)$~', $version->version->get(), $version_in) > 0 &&
          preg_match('~^(\d+)\.(\d+)\.(\d+)-(stable|beta|alpha)$~', $latest->version->get(), $version_current) > 0
        ){
          
          /*
            Match them by integers first.
            Then by stable, beta or alpha, which conveniently is both in alphabetical and version order.
          */
          for($index = 1; $index <= 4; $index++){
            
            //The first 3 are integers, so compare them as such.
            if($index < 4){
              $vin = (int)$version_in[$index];
              $vcur = (int)$version_current[$index];
            }
            
            //The last ones are strings.
            else {
              $vin = $version_in[$index];
              $vcur = $version_current[$index];
            }
            
            if($vin > $vcur){
              $latest = $version;
              break;
            }
            
          }
          
        }
        
      }
      
    });
    
    //Store the latest version by name only.
    $this->latest_version = $latest->version->otherwise(false)->get();
    return $this->latest_version;
    
  }
  
  /**
   * Retrieves the currently installed version of this package.
   * @return string The currently installed version of this package.
   */
  public function current_version(){
    return $this->model()->installed_version->get('string');
  }
  
  /**
   * Update the update system information to match the package information.
   * @return boolean Whether or not syncing was completed successfully.
   */
  public function synchronize()
  {
    
    //Find the package.
    $dbPackage = $this->model();
    
    //Update the package data.
    $dbPackage->merge(array(
      'title' => $this->raw_data()->title,
      'type' => static::TYPE_ID,
      'description' => $this->raw_data()->description
    ))->save();
    
    //Update the versions and their changes.
    $this->raw_data()->versions->each(function($version)use($dbPackage){
      
      //Try find this version.
      $dbVersion = mk('Sql')
        ->table('update', 'PackageVersions')
        ->where('package_id', $dbPackage->id)
        ->where('version', "'{$version->version}'")
        ->execute_single()
        
        //If it doesn't exist, create it now.
        ->is('empty', function()use($version, $dbPackage){
          
          $dbVersion = mk('Sql')
            ->model('update', 'PackageVersions')
            ->set($version->having('version', 'date', 'description'))
            ->package_id->set($dbPackage->id)->back()
            ->save();
          
          //Insert the changes of this version.
          $version->changes->each(function($change)use($dbVersion){
            
            mk('Sql')
              ->model('update', 'PackageVersionChanges')
              ->set($change->having('title', 'description', 'url'))
              ->url->is('empty', function($url){ $url->set('NULL'); })->back()
              ->package_version_id->set($dbVersion->id)->back()
              ->save();
            
          });
          
        })
        
        //Otherwise, only update the information.
        ->failure(function($dbVersion)use($version, $dbPackage){
          
          //First the version itself.
          $dbVersion
            ->merge($version->having('date', 'description'))
            ->save();
          
          //Then the changes.
          //Note: to prevent ridiculous auto incrementing, treat existing changes as an ID pool.
          $dbChanges = $dbVersion->get_changes()->get('array');
          
          $version->changes->each(function($change)use($dbVersion, &$dbChanges){
            
            $dbChange = array_shift($dbChanges);
            
            //When we exhausted our ID pool.
            if(!$dbChange){
              $dbChange = mk('Sql')
                ->model('update', 'PackageVersionChanges')
                ->set(array(
                  'package_version_id' => $dbVersion->id
                ));
            }
            
            //Update our stuff.
            $dbChange
              ->merge($change->having('title', 'description', 'url'))
              ->url->is('empty', function($url){ $url->set('NULL'); })->back()
              ->save();
            
          });
          
          //Delete any changes left in our ID pool. We apparently have less changes than before.
          while($dbChange = array_shift($dbChanges))
            $dbChange->delete();
          
        });
      
    });
    
    return true;
    
  }
  
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
   * Retrieves the raw package data from the package files.
   * @return \dependencies\Data The raw package data.
   */
  abstract public function raw_data();
  
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
   * Gets an instance of the DBUpdates class associated with this package, or null if DBUpdates are not used.
   * @return mixed The DBUpdates instance or null.
   */
  abstract public function db_updates();
  
  /**
   * Gets a model instance, referencing this package.
   * @return \components\update\models\Packages
   */
  abstract public function model();
  
}