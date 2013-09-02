<?php namespace components\update\classes; if(!defined('MK')) die('No direct access.');

use \components\update\enums\PackageType;

class ManualPackage extends AbstractPackage
{
  
  /**
   * The latest version as defined by the raw package data.
   * @var string
   */
  protected $latest_version;
  
  /**
   * Whether or not the raw package data indicates to contain database updates.
   * @var boolean
   */
  protected $db_updates;
  
  /**
   * Create a new instance.
   * @param \components\update\enums\PackageType $type The type of package the instance will refer to.
   * @param string $name The name of the package the instance will refer to.
   */
  public function __construct($type, $name=null)
  {
    
    parent::__construct($type, $name);
    
    //Find the latest version.
    $latest = Data();
    
    if(!$this->raw_data()->type->get('string') === 'manual')
      throw new \exception\Programmer('ManualPackage class used for a package of type %s', $this->raw_data()->type->get('string'));
    
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
          for($index = 1; $index < 5; $index++){
            
            if((int)$version_in[$index] > (int)$version_current[$index]){
              $latest = $version;
              break;
            }
            
          }
          
        }
        
      }
      
    });
    
    //Store the latest version by name only.
    $this->latest_version = $latest->version->otherwise(false)->get();
    
    //Check whether database updates are present.
    $this->db_updates = $this->raw_data()->dbUpdates->get('boolean');
    
  }
  
  /**
   * Update the update system information to match the package information.
   * @return boolean Whether or not syncing was completed successfully.
   */
  public function synchronize()
  {
    
    mk('Logging')->log('ManualPackage', 'Syncing', $this->raw_data()->title);
    
    //Find the package.
    $dbPackage = $this->model();
    
    //Update the package data.
    $dbPackage->merge(array(
      'title' => $this->raw_data()->title,
      'type' => 0, //manual type
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
  public function update($forced=false, $allow_sync=false)
  {
    
    if($allow_sync)
      $this->synchronize();
    
    //If we have a next version to update to.
    if($this->next_version() || $this->current_version() === ''){
      
      //And we have DB updates...
      if($this->db_updates()){
        return $this->db_updates()->update($forced, true);
      }
      
      //Otherwise go straight to the target version.
      else {
        return $this->version_bump($this->next_version());
      }
      
    }
    
    return false;
    
  }
  
  /**
   * Retrieves the reference ID of this package.
   * @return string The reference ID of this package.
   */
  public function reference_id()
  {
    
    //Check our own records first.
    if(isset($this->reference_id))
      return $this->reference_id;
    
    //Where the reference at?
    $reference_file = $this->directory().DS.'.package'.DS.'reference-id';
    
    //If the file is not there, we do not have a reference ID yet.
    if(!is_file($reference_file))
      return null;
    
    //Otherwise, cache it, since it's not going to change often.
    $this->reference_id = file_get_contents($reference_file);
    return $this->reference_id;
    
  }
  
  /**
   * Gets the (absolute) base directory of this package.
   * @return string The base directory of this package.
   */
  public function directory(){
    return PackageFactory::directory($this->type, $this->name);
  }
  
  /**
   * Retrieves the raw package data from the package files.
   * @return \dependencies\Data The raw package data.
   */
  public function raw_data()
  {
    
    //Check our cache first.
    if(isset($this->raw_data))
      return $this->raw_data;
    
    //Where the package at?
    $package_file = $this->directory().DS.'.package'.DS.'package.json';
    
    //Make sure the package file is there.
    if(!is_file($package_file))
      throw new \exception\FileMissing('Package does not contain a package.json file');
    
    //Get the package data.
    $this->raw_data = Data(json_decode(file_get_contents($package_file), true));
    return $this->raw_data;
    
  }
  
  /**
   * Retrieves the currently installed version of this package.
   * @return string The currently installed version of this package.
   */
  public function current_version(){
    return $this->model()->installed_version->get('string');
  }
  
  /**
   * Retrieves the latest available version of this package.
   * @return string The latest available version of this package.
   */
  public function latest_version(){
    return $this->latest_version;
  }
  
  /**
   * Determines the next version that should be installed in the update order defined.
   * @param  string $version The version that is currently installed.
   * @return string The version that should be installed next.
   */
  public function next_version($version=null)
  {
    
    //When there are no DB updates, there is no upgrade order.
    if(!$this->db_updates)
    {
      
      //If we're already at the latest version, don't do anything.
      if($this->current_version() == $this->latest_version())
        return false;
      
      //Otherwise just go straight to the latest.
      else
        return $this->latest_version();
      
    }
    
    //When there are, delegate this to the DB updates class.
    return $this->db_updates()->next_version($version);
    
  }
  
  /**
   * Tracks a version update of the package.
   * Note: $allow_sync should only be set to true to allow the update component to install itself.
   * @param string $version The version of the package that is now installed.
   * @param boolean $allow_sync Whether or not to allow the package to be synced, to obtain version information.
   * @return boolean Whether or not the version update was successful.
   */
  public function version_bump($version, $allow_sync=false)
  {
    
    raw($version);
    
    //We need to clear this cache regularly, because otherwise this may mess up the ORM during install.
    if($this->db_updates){
      \dependencies\BaseModel::clear_table_data_cache();
    }
    
    //In case of a self-install the package will not be inserted yet.
    if($allow_sync){
      
      //Update the version data from the package.json.
      $this->synchronize();
      
    }
    
    //Normal version bump.
    $version = mk('Sql')
      ->table('update', 'PackageVersions')
      ->where('package_id', $this->model()->id)
      ->where('version', "'{$version}'")
      ->execute_single()
      ->is('empty', function()use($version){
        throw new \exception\NotFound('Version '.$version.' is not defined for package '.$this->model()->title);
      });
    
    //Do the bump.
    $this->model()->merge(array(
      'installed_version' => $version->version,
      'installed_version_date' => $version->date
    ))->save();
    
  }
  
  /**
   * Gets an instance of the DBUpdates class associated with this package, or null if not DBUpdates are used.
   * @return mixed The DBUpdates instance or null.
   */
  public function db_updates()
  {
    
    //When no DBUpdates are desired by the package, return null.
    if(!$this->db_updates)
      return null;
    
    //Include the DBUpdates class file.
    require_once($this->directory().DS.'.package'.DS.'DBUpdates'.EXT);
    
    //Depending on the type, get it's instance.
    switch ($this->type) {
      case PackageType::CORE:       return new \core\DBUpdates();
      case PackageType::COMPONENT:  $class = "\\components\\{$this->name}\\DBUpdates"; return new $class();
      case PackageType::TEMPLATE:   $class = "\\templates\\{$this->name}\\DBUpdates"; return new $class();
      case PackageType::THEME:      $class = "\\themes\\{$this->name}\\DBUpdates"; return new $class();
      default: throw new \exception\Programmer('Invalid PackageType value '.$type);
    }
    
  }
  
  /**
   * Gets a model instance, referencing this package.
   * @return \components\update\models\Packages
   */
  public function model()
  {
    
    //Do some caching.
    if($this->model) return $this->model;
    
    //We can only do manual types.
    if($this->raw_data()->type->get() !== 'manual')
      throw new \exception\Exception('Package type other than manual has not been implemented yet.');
    
    //Reference this instance.
    $that = $this;
    
    //See if we have a reference for this package.
    $reference_file = $this->directory().DS.'.package'.DS.'reference-id';
    $reference_support = static::reference_support();
    if(file_exists($reference_file) && $reference_support)
    {
      
      $reference = file_get_contents($reference_file);
      try{
        $model = mk('Sql')
          ->table('update', 'Packages')
          ->where('reference_id', "'$reference'")
          ->execute_single()
          ->is('empty', function()use($reference_file){
            mk('Logging')->log('ManualPackage', 'Referencing', 'Invalid reference found for '.$this->raw_data()->title.', deleting.');
            unlink($reference_file);
          });
      }
      
      //If this broke, we don't have this reference_id field yet or the update component is not installed.
      catch(\exception\Sql $ex){
        mk('Logging')->log('ManualPackage', 'Referencing', 'Unable to query reference-id. '.$ex->getMessage());
      }
      
    }
    
    //Perhaps we have a chance to create a reference now.
    else
    {
      
      //Get the package from the database.
      //Use a try catch in case we're installing the update package and the tables don't exist.
      try{
        $model = mk('Sql')
          ->table('update', 'Packages')
          ->where('title', "'".$this->raw_data()->title."'")
          ->execute_single();
      }
      
      //In case of a Sql exception we are self-installing.
      //Return an empty data object.
      catch(\exception\Sql $ex){
        //Create an empty placeholder.
        $model = Data();
      }
      
      if($reference_support){
        try
        {
          
          //Create a unique reference key.
          do {
            
            $reference = mk('Security')->random_string(40);
            
            $matches = mk('Sql')
              ->table('update', 'Packages')
              ->where('reference_id', "'$reference'")
              ->count();
            
          } while($matches->get('int') > 0);
          
          //Update the package with this reference key.
          $model->merge(array(
            'reference_id' => $reference
          ))->save();
          
          //Save the reference to the file.
          file_put_contents($reference_file, $reference);
          
        }
        
        //An exception here means that references aren't yet supported by the installed update component.
        catch(\exception\Sql $ex){
          mk('Logging')->log('ManualPackage', 'Referencing', 'Unable to create new reference-id. '.$ex->getMessage());
        }
      } else {
        $reference = 'NULL';
      }
      
    }
    
    //Don't cache and return a new model if the package was not in the database.
    if($model->is_empty()){
      return mk('Sql')->model('update', 'Packages')->set(array(
        'title' => $this->raw_data()->title,
        'description' => $this->raw_data()->description,
        'type' => 0
      ));
    }
    
    $this->model = $model;
    return $model;
    
  }
  
}