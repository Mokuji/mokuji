<?php namespace components\update\packages; if(!defined('MK')) die('No direct access.');

use \components\update\enums\PackageType;

class ReadmePackage extends AbstractPackage
{
  
  /**
   * The type ID used in the packages table.
   * @var int
   */
  const TYPE_ID = 1;
  
  protected static
    $header_line = '~^#+[ ]*(.+)$~',
    $description_line = '~^[\*_]{2}(.+)[\*_]{2}$~',
    $changes_header_line = '~^#+[ ]*(Changes|Change[ ]log|History|Change history):?$~i',
    $change_line = '~^[\*\-][ ]+([^\:]+)\:(.+)?$~';
  
  /**
   * Parses the given README.md file into package information.
   * @param  string $filename The absolute filename of the README.md file.
   * @return array An array with keys and values for the parsed entities.
   */
  public static function parse_readme($filename)
  {
    
    $readme = file_get_contents($filename);
    $lines = explode(n, $readme);
    
    //Add some static data.
    $result = array(
      'type' => 'readme',
      'dbUpdates' => false
    );
    
    //The first line should define a title.
    if(preg_match(static::$header_line, trim($lines[0]), $match)){
      $result['title'] = trim($match[1]);
    }
    
    //Continue from the following line.
    $i = 1;
    
    //Now seek to a line that has a bold phrase, before the next header.
    while(array_key_exists($i, $lines)){
      $line = trim($lines[$i]);
      
      //See if we've got a description here.
      if(preg_match(static::$description_line, $line, $match)){
        $result['description'] = trim($match[1]);
        $i++;
        break;
      }
      
      //If not, make sure it's not a header.
      if(preg_match(static::$header_line, $line, $match)){
        break;
      }
      
      $i++;
    }
    
    //Now look for a header that denotes a change log.
    while(array_key_exists($i, $lines)){
      $line = trim($lines[$i]);
      
      //See if we have a change log header.
      if(preg_match(static::$changes_header_line, $line, $match)){
        $result['versions'] = array();
        $i++;
        break;
      }
      
      $i++;
    }
    
    //The following lines are either blank or changes.
    while(array_key_exists($i, $lines)){
      $line = trim($lines[$i]);
      
      //See if we have a change line.
      if(preg_match(static::$change_line, $line, $match)){
        $timestamp = strtotime(trim($match[1]));
        
        //Valid time?
        if(!$timestamp > 0){
          throw new \exception\Unexpected('Invalid date-time format: %s', trim($match[1]));
        }
        
        $result['versions'][] = array(
          'date' => date('Y-m-d', $timestamp),
          'description' => trim($match[2])
        );
      }
      
      //When there's something besides a change line or empty line, break the changes loop.
      elseif(!empty(trim($line))){
        break;
      }
      
      $i++;
    }
    
    //Do some arbitrary stuff for the change log.
    if(array_key_exists('versions', $result))
    {
      
      //Order the versions by date.
      usort($result['versions'], function($a, $b){
        $ta = strtotime($a['date']);
        $tb = strtotime($b['date']);
        if($ta == $tb)
          return 0;
        return ($ta < $tb) ? -1 : 1;
      });
      
      //Now give them arbitrary version numbers.
      $currentVersion = 1;
      $count = count($result['versions']);
      for($cv = 1; $cv <= $count; $cv++){
        $result['versions'][$cv-1]['version'] = $cv.'.0.0-stable';
      }
      
    }
    
    return $result;
    
  }
  
  /**
   * Checks whether the requirements are met for this type of Package.
   * @return boolean
   */
  public static function check($type, $name=null)
  {
    
    #TODO: Support plug-ins with this style as well?
    //We only support themes and templates at the moment.
    switch($type) {
      
      //These are good.
      case PackageType::THEME:
      case PackageType::TEMPLATE:
        break;
      
      //The others are not.
      default: return false;
      
    }
    
    //There should be a README.md file in the directory for this type.
    $directory = PackageFactory::directory($type, $name);
    return is_file($directory.DS.'README.md');
    
  }
  
  /**
   * Update the update system information to match the package information.
   * @return boolean Whether or not syncing was completed successfully.
   */
  public function synchronize(){
    mk('Logging')->log('ReadmePackage', 'Syncing', $this->raw_data()->title);
    return parent::synchronize();
  }
  
  /**
   * Perform an update to the latest version of the package.
   * @param  boolean $forced     Forced update?
   * @param  boolean $allow_sync Syncing allowed?
   * @return boolean Whether or not new versions were installed.
   */
  public function update($forced=false, $allow_sync=false)
  {
    
    //If we can, why not?
    if($allow_sync)
      $this->synchronize();
    
    //Updating is pretty simple. If the theme / template is not in the CMS tables, add it!
    //Other than that it's just package information that the synchronize function handles.
    
    switch($this->type){
      case PackageType::THEME: $modelName = 'Themes'; break;
      case PackageType::TEMPLATE: $modelName = 'Templates'; break;
      default: throw new \exception\Programmer('Package type %s is not supported.', $this->type);
    }
    
    //Keep track of modifications to the CMS model.
    $modified = false;
    
    //Find the CMS entry.
    $model = mk('Sql')->table('cms', $modelName)
      ->where('name', mk('Sql')->escape($this->name))
      ->execute_single();
    
    //It wasn't there, so create it.
    if($model->is_empty()){
      
      $model = mk('Sql')->model('cms', $modelName)
        ->set(array(
          'name' => $this->name,
          'title' => $this->model()->title
        ))
        ->save();
      
      $modified = true;
      
    }
    
    //We might have to update the title.
    elseif($model->title->get() !== $this->model()->title->get())
    {
      
      $model
        ->merge(array('title' => $this->model()->title))
        ->save();
      
      $modified = true;
      
    }
    
    //If we have a next version to update to.
    if($this->next_version() || $this->current_version() === ''){
      
      //Go straight to the target version.
      return $this->version_bump($this->next_version()) || $modified;
      
    }
    
    return $modified;
    
  }
  
  /**
   * Retrieves the reference ID of this package.
   * @return string The reference ID of this package.
   */
  public function reference_id(){
    //This style doesn't create random ID's but uses a predictable one.
    //"4:example" would be a theme (PackageType::THEME = 4) in the "example" folder.
    return "{$this->type}:{$this->name}";
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
    
    //Where the readme at?
    $package_file = $this->directory().DS.'README.md';
    
    //Make sure the package file is there.
    if(!is_file($package_file))
      throw new \exception\FileMissing('Package does not contain a README.md file at %s', $package_file);
    
    //Get the package data.
    $this->raw_data = Data(self::parse_readme($package_file));
    return $this->raw_data;
    
  }
  
  /**
   * Determines the next version that should be installed in the update order defined.
   * @param  string $version The version that is currently installed.
   * @return string The version that should be installed next.
   */
  public function next_version($version=null)
  {
    
    //In case we're at the latest, we don't have a next one.
    if($this->current_version() === $this->latest_version())
      return false;
    
    //Otherwise go right to the latest.
    return $this->latest_version();
    
  }
  
  /**
   * Tracks a version update of the package.
   * Note: $allow_sync should only be set to true to allow the update component to install itself.
   * @param string $version The version of the package that is now installed.
   * @param boolean $allow_sync Whether or not to allow the package to be synced, to obtain version information.
   * @return boolean Whether or not the version update was successful.
   */
  public function version_bump($version, $allow_sync=false){
    
    $self = $this;

    raw($version);
    
    //If we can sync, why not do so?
    if($allow_sync){
      $this->synchronize();
    }
    
    //Normal version bump.
    $version = mk('Sql')
      ->table('update', 'PackageVersions')
      ->where('package_id', $this->model()->id)
      ->where('version', "'{$version}'")
      ->execute_single()
      ->is('empty', function()use($self, $version){
        throw new \exception\NotFound('Version '.$version.' is not defined for package '.$self->model()->title);
      });
    
    //Do the bump.
    $this->model()->merge(array(
      'installed_version' => $version->version,
      'installed_version_date' => $version->date
    ))->save();
    
    return true;
    
  }
  
  /**
   * Gets an instance of the DBUpdates class associated with this package, or null if DBUpdates are not used.
   * @return mixed The DBUpdates instance or null.
   */
  public function db_updates(){
    return null;
  }
  
  /**
   * Gets a model instance, referencing this package.
   * @return \components\update\models\Packages
   */
  public function model()
  {
    
    //When cached, save some effort.
    if(isset($this->model))
      return $this->model;
    
    //Either find one with the reference ID...
    $reference = $this->reference_id();
    $model = mk('Sql')->table('update', 'Packages')
      ->where('reference_id', mk('Sql')->escape($reference))
      ->execute_single();
    
    //In which case we cache it.
    if(!$model->is_empty()){
      $this->model = $model;
      return $this->model;
    }
    
    //Or create a new one.
    else{
      return mk('Sql')->model('update', 'Packages')->set(array(
        'title' => $this->raw_data()->title,
        'description' => $this->raw_data()->description,
        'type' => self::TYPE_ID,
        'reference_id' => $reference
      ));
    }
    
  }
  
}