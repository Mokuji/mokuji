<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

/**
 * The Superclass that allows for the mk() notation of loading core classes. Your main gateway of expression in the Tuxion CMS.
 */
class Superclass
{
	
  /**
   * The private array that holds the core class singletons and an instance of itself.
   */
  private static $system=array();
	
  /**
   * Retrieves the superclass singleton instance.
   * Note: uses lazy initiation.
   * @return \Superclass
   * @throws \exception\Unexpected
   */
	public static function & get_instance()
	{
		if(!array_key_exists('superobject', self::$system)){
			if(!self::$system['superobject'] = new Superclass){
				throw new \exception\Unexpected('Failed to create superobject');
			}
		}
		return self::$system['superobject'];
	}
	
  /**
   * Loads the core class with the given name.
   * @param String $class The name of the core class to load. (Case sensitive)
   * @param Array $args An optional array of arguments to supply to the `init` function if this is the first time it loads.
   * @return Object The singleton object of the requested class.
   * @throws \exception\FileMissing If the core class could not be found.
   */
	public function load_class($class, $args=array())
	{
		
    if(empty($class)){
      throw new \exception\InvalidArgument('Class name was empty');
    }

		//we change any user fails to a pretty class name
		$class_name = ucfirst(strtolower($class));
    $class = '\\core\\'.$class_name;
    
		//if this class hasn't been defined yet...
		if(!array_key_exists($class, self::$system))
		{
      //...we check if given class is present...
			if(!is_file(PATH_SYSTEM_CORE.DS.$class_name.EXT)){
				throw new \exception\FileMissing("Core class '%s' was not found.", $class);
			}

			//...if so, we load it
			require_once(PATH_SYSTEM_CORE.DS.$class_name.EXT);
			$instance = new $class;
      self::$system[$class] = $instance;
      
      // if this class has an init function, this is the time to call it.
      if(method_exists($instance, 'init')){
        call_user_func_array(array($instance, 'init'), $args);
      }
      
		}

		//return the class
		return self::$system[$class];
    
	}
	
}
