<?php namespace components\update\classes; if(!defined('MK')) die('No direct access.');

use \components\update\enums\PackageType;

abstract class PackageFactory
{
  
  /**
   * The packages that have already been requested.
   * @var array
   */
  protected static $cached_packages = array();
  
  /**
   * Gets the package class corresponding to provided type and name.
   * @param  PackageType $type The type of package to retrieve.
   * @param  string $name The name of the package to retrieve (optional for the core).
   * @return AbstractPackage The package class corresponding to this package.
   */
  public static function get($type, $name=null)
  {
    
    switch ($type) {
      
      case PackageType::CORE:
        
        //Check if we have the core cached.
        if(array_key_exists($type, self::$cached_packages))
          return self::$cached_packages[$type];
        
        break; //Not cached.
      
      case PackageType::COMPONENT:
      case PackageType::TEMPLATE:
      case PackageType::THEME:
        
        //Make sure the name is not empty.
        if(empty($name))
          throw new \exception\Programmer('The package name can not be empty, except for the core.');
        
        //Check if we have a cache for this type.
        if(!array_key_exists($type, self::$cached_packages))
          self::$cached_packages[$type] = array();
        
        //Check if we have this instance.
        if(array_key_exists($name, self::$cached_packages[$type]))
          return self::$cached_packages[$type][$name];
        
        break; //Not cached.
        
      default:
        throw new \exception\Programmer('Invalid PackageType value '.$type);
        
    }
    
    #TODO: We only have one package class so far. Later on, detect the differences.
    $package = new ManualPackage($type, $name);
    
    //Now cache this package.
    switch ($type) {
      
      //Cache the core.
      case PackageType::CORE:
        self::$cached_packages[$type] = $package;
        break;
      
      //Cache the other types.
      case PackageType::COMPONENT:
      case PackageType::TEMPLATE:
      case PackageType::THEME:
        self::$cached_packages[$type][$name] = $package;
        break;
        
      default:
        throw new \exception\Programmer('Invalid PackageType value '.$type);
        
    }
    
    //And finally return it.
    return $package;
    
  }
  
  /**
   * Gets the (absolute) base directory of this package.
   * @param PackageType $type The type of package.
   * @param string      $name The name of the package.
   * @return string The base directory of this package.
   */
  public static function directory($type, $name=null)
  {
    
    switch($type){
      case PackageType::CORE:       return PATH_FRAMEWORK;
      case PackageType::COMPONENT:  return PATH_COMPONENTS.DS.$name;
      case PackageType::TEMPLATE:   return PATH_TEMPLATES.DS.$name;
      case PackageType::THEME:      return PATH_THEMES.DS.$name;
      default: throw new \exception\Programmer('Invalid PackageType value '.$type);
    }
    
  }
  
}