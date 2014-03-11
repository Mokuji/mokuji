<?php namespace components\update\classes; if(!defined('TX')) die('No direct access.');

use \components\update\enums\PackageType;
use \components\update\packages\PackageFactory;

abstract class BaseDBUpdates
{
  
  /*
  
  Static properties:
  - core_package_data
  - component_package_data
  - template_package_data
  - theme_package_data
  - queued_operations
  
  Properties:
  ~ component
  ~ is_core
  ~ template
  ~ theme
  ~ updates
  - package
  
  Static methods:
    base_dir
    clear_global_cache
    init_statics
    package_data
    process_queue
  
  Methods:
  + clear_cache
  + __construct
  + current version
  + install
  + latest version
  + uninstall
  + update
  ~ backup
  ~ get_base dir
  ~ get_package data
  ~ package
  ~ next version
  ~ queue
  - version bump
  
  */
  
  static private
    $core_package_data,
    $component_package_data,
    $template_package_data,
    $theme_package_data,
    $queued_operations;
  
  protected
    $component,
    $is_core,
    $template,
    $theme,
    $updates,
    $type,
    $name;
  
  private
    $package;
  
  /* ---------- Static ---------- */
  
  static function base_dir($type = PackageType::CORE, $name = null){
    return PackageFactory::directory($type, $name);
  }
  
  static function package_data($type = PackageType::CORE, $name = null){
    return PackageFactory::get($type, $name)->raw_data();
  }
  
  static function clear_global_cache()
  {
    
    self::$core_package_data = null;
    self::$component_package_data = null;
    self::$template_package_data = null;
    self::$theme_package_data = null;
    
  }
  
  static function init_statics()
  {
    
    //Use an array unfortunately, because Data() does not support storing closures.
    self::$queued_operations = array();
    
  }
  
  static function process_queue()
  {
    
    //It might be we never queued anything.
    if(!isset(self::$queued_operations))
      return;
    
    //Go over each queue element.
    foreach(self::$queued_operations as $operation_data)
    {
      
      //Find out what this component is.
      $package = self::package_data(PackageType::COMPONENT, $operation_data['component']);
      $package_db = PackageFactory::get(PackageType::COMPONENT, $operation_data['component'])->model()
        
        //In case it's not found.
        ->is('empty', function(){
          throw new \exception\NotFound('The package for this component could not be found in the database');
        });
      
      //Get the version we're talking about.
      $version = mk('Sql')
        ->table('update', 'PackageVersions')
        ->where('package_id', $package_db->id)
        ->where('version', "'{$operation_data['min_version']}'")
        ->execute_single()
        
        //In case it's not found.
        ->is('empty', function()use($operation_data){
          throw new \exception\NotFound('The min_version "%s" was not found, it needs to be listed in the package.json of it\'s component "%s".', $operation_data['min_version'], $operation_data['component']);
        });
      
      //Find out if this or a later version has been installed.
      $current = strtotime($package_db->installed_version_date->get('string'));
      $min = strtotime($version->date->get('string'));
      
      //Uh oh!
      if($current < $min)
        throw new \exception\Expected('The installed version (%s) is lower than the minimum version (%s) for this operation on component %s', $current, $min, $operation_data['component']);
      
      //Otherwise, execute the operation.
      $operation_data['operation']($package_db->installed_version->get());
      
    }
    
  }
  
  /* ---------- Public ---------- */
  
  public function clear_cache()
  {
    
    $this->package = null;
    self::clear_global_cache();
    
  }
  
  public function __construct()
  {
    
    //Find out our type.
    if(!isset($this->type))
    {
      
      if($this->is_core === true)
        $this->type = PackageType::CORE;
      
      elseif(isset($this->component)){
        $this->type = PackageType::COMPONENT;
        $this->name = $this->component;
      }
      
      elseif(isset($this->template)){
        $this->type = PackageType::TEMPLATE;
        $this->name = $this->template;
      }
      
      elseif(isset($this->theme)){
        $this->type = PackageType::THEME;
        $this->name = $this->theme;
      }
      
      else
        throw new \exception\Programmer('Type has not been defined for the DBUpdates instance, use protected attribute $type for this');
      
    }
    
    //We are lazy and prefer to set an array on the implementation classes.
    $this->updates = Data($this->updates);
    
  }
  
  public function current_version(){
    return PackageFactory::get($this->type, $this->name)->current_version();
  }
  
  public function install($dummydata=false, $forced=false, $update_to_latest=true)
  {
    
    $that = $this;
    raw($dummydata, $forced, $update_to_latest);
    
    if(!$this->package()->installed_version->is_empty() && $forced !== true)
      throw new \exception\Exception('Package '.$this->package()->title.' has already been installed and $forced is false');
    
    //Save the latest version.
    $latest = Data();
    
    //Go over each version.
    $this->get_package_data()->versions->each(function($version)use(&$latest, $that){
      
      //If this is a later version.
      $version->timestamp->set(strtotime($version->date->get()));
      if($version->timestamp->get() > $latest->timestamp->get())
      {
        
        if(method_exists($that, 'install_'.vtfn($version->version)))
          $latest = $version;
        
      }
      
    });
    
    if($latest->is_empty()) throw new \exception\Exception('No install method exists for package '.$this->package()->title);
    
    $method = 'install_'.vtfn($latest->version);
    tx('Logging')->log('Update', 'Installing DB', 'Calling '.$method.' for package '.$this->package()->title.' from version '.$this->current_version());
    call_user_func_array(array($this, $method), array($dummydata, $forced));
    $this->version_bump($latest->version, true);
    
    if($update_to_latest === true) $this->update($forced);
    return true;
    
  }
  
  public function latest_version(){
    return PackageFactory::get($this->type, $this->name)->latest_version();
  }
  
  public function uninstall($forced=false)
  {
    
    throw new \exception\Exception('Not implementated yet');
    
  }
  
  public function update($forced=false, $maybe_install=false)
  {
    
    raw($forced, $maybe_install);
    
    //If we're at the current version, there's nothing to do.
    if($this->current_version() === $this->latest_version()) return false;
    
    //If there's no current_version set, we need to install from scratch. If the parameters allow it.
    if($this->current_version() == '')
    {
      
      if($maybe_install === true){
        $this->install(false, $forced, true);
        return true;
      }
      
      else{
        throw new \exception\Exception('Update was called with $maybe_install set to false and no version was previously installed');
      }
      
    }
    
    //What is the update method for this?
    $next = $this->next_version();
    
    if(!$next){
      tx('Logging')->log('Update', 'Updating DB', 'Dead end in update path for package '.$this->package()->title.' at version '.$this->current_version());
      return false;
    }
    
    $method = 'update_to_'.vtfn($next);
    
    //If it exists, call it.
    if(method_exists($this, $method))
    {
      tx('Logging')->log('Update', 'Updating DB', 'Calling '.$method.' for package '.$this->package()->title.' from version '.$this->current_version());
      call_user_func_array(array($this, $method), array($this->current_version(), $forced));
    }
    
    //Otherwise just report we're skipping it, but once looked for it.
    else{
      tx('Logging')->log('Update', 'Updating DB', 'No method '.$method.' for package '.$this->package()->title.' from version '.$this->current_version());
    }
    
    //Bump version.
    $this->version_bump($next);
    
    //Repeat.
    $this->update($forced, $maybe_install);
    return true;
    
  }
  
  public function next_version($version=null)
  {
    
    //Raw data.
    raw($version);
    
    //If none is given, get the current version.
    if(!$version) $version = $this->current_version();
    
    //Get the next version.
    $version = $this->updates->{$version};
    if($version->is_set())
      return $version->get();
    return false;
    
  }
  
  /* ---------- Protected ---------- */
  
  protected function get_base_dir(){
    return self::base_dir($this->type, $this->name);
  }
  
  protected function get_package_data(){
    return PackageFactory::get($this->type, $this->name)->raw_data();
  }
  
  protected function package(){
    return PackageFactory::get($this->type, $this->name)->model();
  }
  
  protected function queue($data, \Closure $operation)
  {
    
    //Note: this function does not queue for core versions, only components.
    //This is because the core updates are always executed first so no queue is needed from components to the core.
    //And the core is still able to queue for components, should that for some awkward reason ever be needed.
    
    //Validate input.
    $data = Data($data)->having('component', 'min_version')
      ->component->validate('Component', array('required', 'string', 'not_empty'))->back()
      ->min_version->validate('Minimum version', array('required', 'string', 'not_empty'))->back()
    ;
    
    //See if the component is availabe.
    if(!tx('Component')->available($data->component))
      throw new \exception\NotFound('The component '.$data->component.' is not available.');
    
    //Since the min_version we designated might still be in the line-up to be installed,
    // wait untill later to check this is a valid version or whether it will be installed at all.
    array_push(self::$queued_operations, array(
      'component' => $data->component->get(),
      'min_version' => $data->min_version->get(),
      'operation' => $operation
    ));
    
  }
  
  private function version_bump($version, $is_install=false){
    
    //Allow sync when installing update component.
    $allow_sync =
      $is_install &&
      $this->type === PackageType::COMPONENT &&
      $this->name === 'update';
    
    PackageFactory::get($this->type, $this->name)->version_bump($version, $allow_sync);
    
  }
  
}

//Initialize the static things.
BaseDBUpdates::init_statics();
