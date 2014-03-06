<?php namespace components\update\packages; if(!defined('MK')) die('No direct access.');

use \components\update\enums\PackageType;

class ReadmePackage /*extends AbstractPackage*/
{
  
  const HEADER_LINE = '~^#+[ ]*(.+)$~';
  const DESCRIPTION_LINE = '~^[\*_]{2}(.+)[\*_]{2}$~';
  const CHANGES_HEADER_LINE = '~^#+[ ]*(Changes|Change[ ]log|History|Change history):?$~i';
  const CHANGE_LINE = '~^[\*\-][ ]+([^\:]+)\:(.+)?$~';
  
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
    if(preg_match(self::HEADER_LINE, trim($lines[0]), $match)){
      $result['title'] = trim($match[1]);
    }
    
    //Continue from the following line.
    $i = 1;
    
    //Now seek to a line that has a bold phrase, before the next header.
    while(array_key_exists($i, $lines)){
      $line = trim($lines[$i]);
      
      //See if we've got a description here.
      if(preg_match(self::DESCRIPTION_LINE, $line, $match)){
        $result['description'] = trim($match[1]);
        $i++;
        break;
      }
      
      //If not, make sure it's not a header.
      if(preg_match(self::HEADER_LINE, $line, $match)){
        break;
      }
      
      $i++;
    }
    
    //Now look for a header that denotes a change log.
    while(array_key_exists($i, $lines)){
      $line = trim($lines[$i]);
      
      //See if we have a change log header.
      if(preg_match(self::CHANGES_HEADER_LINE, $line, $match)){
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
      if(preg_match(self::CHANGE_LINE, $line, $match)){
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
  
  // /**
  //  * Update the update system information to match the package information.
  //  * @return boolean Whether or not syncing was completed successfully.
  //  */
  // public function synchronize()
  // {
    
    
    
  // }
  
  // /**
  //  * Perform an update to the latest version of the package.
  //  * @param  boolean $forced     Forced update?
  //  * @param  boolean $allow_sync Syncing allowed?
  //  * @return boolean Whether or not new versions were installed.
  //  */
  // abstract public function update($forced=false, $allow_sync=false);
  
  // /**
  //  * Retrieves the reference ID of this package.
  //  * @return string The reference ID of this package.
  //  */
  // abstract public function reference_id();
  
  // /**
  //  * Retrieves the raw package data from the package files.
  //  * @return \dependencies\Data The raw package data.
  //  */
  // abstract public function raw_data();
  
  // /**
  //  * Retrieves the currently installed version of this package.
  //  * @return string The currently installed version of this package.
  //  */
  // abstract public function current_version();
  
  // /**
  //  * Retrieves the latest available version of this package.
  //  * @return string The latest available version of this package.
  //  */
  // abstract public function latest_version();
  
  // /**
  //  * Determines the next version that should be installed in the update order defined.
  //  * @param  string $version The version that is currently installed.
  //  * @return string The version that should be installed next.
  //  */
  // abstract public function next_version($version=null);
  
  // /**
  //  * Tracks a version update of the package.
  //  * Note: $allow_sync should only be set to true to allow the update component to install itself.
  //  * @param string $version The version of the package that is now installed.
  //  * @param boolean $allow_sync Whether or not to allow the package to be synced, to obtain version information.
  //  * @return boolean Whether or not the version update was successful.
  //  */
  // public function version_bump($version, $allow_sync=false){
  //   return true;
  // }
  
  // /**
  //  * Gets an instance of the DBUpdates class associated with this package, or null if DBUpdates are not used.
  //  * @return mixed The DBUpdates instance or null.
  //  */
  // public function db_updates(){
  //   return null;
  // }
  
  // /**
  //  * Gets a model instance, referencing this package.
  //  * @return \components\update\models\Packages
  //  */
  // abstract public function model();
  
}