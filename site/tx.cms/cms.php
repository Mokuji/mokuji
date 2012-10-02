<?php if(!defined('TX')) die('No direct access.');

//Superclass
class Superclass
{
	
  private static $system=array();
	
	//singleton selfload
	public static function & get_instance()
	{
		if(!array_key_exists('superobject', self::$system)){
			if(!self::$system['superobject'] = new Superclass){
				throw new \exception\Unexpected('Failed to create superobject');
			}
		}
		return self::$system['superobject'];
	}
	
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

//return superobject or class within superobject
function tx()
{
	
  
  if(func_num_args() == 0 || is_null(func_get_arg(0))){
		return Superclass::get_instance();
	}
  
  elseif(func_num_args() == 2 && is_string(func_get_arg(0)) && (func_get_arg(1) instanceof \Closure)){
    return new \dependencies\UserFunction(func_get_arg(0), func_get_arg(1));
  }
  
  elseif(func_num_args() == 1 && (func_get_arg(0) instanceof \Closure)){
    return new \dependencies\UserFunction(null, func_get_arg(0));
  }
  
  else{
    $args = func_get_args();
    $class = array_shift($args);
		return Superclass::get_instance()->load_class($class, $args);
	}
  
  return false;
  
}
