<?php if(!defined('TX')) die('No direct access.');

function __autoload($class)
{
  
  if(substr_count($class, '\\') === 0){
    return __autoload('dependencies\\'.$class);
  }
  
  $class_array = explode('\\', $class);
  
  switch($class_array[0])
  {
    
    //Some servers freak out if you start with \\ in the namespace.
    case '':
      return __autoload(substr($class, 1));
    
    case 'dependencies':
      array_shift($class_array);
      $sub_path = implode(DS, $class_array);
      if(!is_file(PATH_SYSTEM_DEPENDENCIES.DS.$sub_path.EXT)){
        throw new \exception\FileMissing('Dependency \'%s\' does not exist', $class);
        return;
      }
      require_once(PATH_SYSTEM_DEPENDENCIES.DS.$sub_path.EXT);
      break;
    
    case 'exception':
      if(!is_file(PATH_SYSTEM_EXCEPTIONS.DS.$class_array[1].EXT)){
        throw new \exception\FileMissing('Exception \'%s\' does not exist', $class);
        return;
      }
      require_once(PATH_SYSTEM_EXCEPTIONS.DS.$class_array[1].EXT);
      break;
      
    default:
      die("Failed to autoload '$class'; autoloading is restricted to only exception classes or dependency classes.<pre>".callstack().'</pre>');
      return;
      
  }
  
  return $class;
  
}

function load_model($component_name, $model_name)
{
  
  $component_name = data_of($component_name);
  $model_name = data_of($model_name);
  
  tx('Component')->check($component_name);
  
  if(empty($model_name)){
    throw new \exception\InvalidArgument("Component name can not be empty");
  }
  
  $model_name = ucfirst($model_name);
  
  $model = "\\components\\$component_name\\models\\$model_name";
  
  if(!class_exists($model, false))
  {
    
    if(!preg_match('~[A-Z][A-Za-z_]+~', $model_name)){
      throw new \exception\InvalidArgument('Model name contains invalid characters.');
    }
    
    if(!is_file(PATH_COMPONENTS.DS.$component_name.DS.'models'.DS.$model_name.EXT)){
      throw new \exception\FileMissing("Model '%s' does not exist", $model_name);
    }
    
    require_once(PATH_COMPONENTS.DS.$component_name.DS.'models'.DS.$model_name.EXT);
  
  }
  
  return $model;
  
}

function load_module()
{
  
  throw new \exception\Deprecated("The load_module helper has been moved to tx('Controller')->load_module().");

}

function plugin_available($name)
{
  return file_exists(PATH_PLUGINS.DS.$name.DS.'plugin'.EXT);
}

function load_plugin($name, $___once=true)
{
  
  return load_html(PATH_PLUGINS.DS.$name.DS.'plugin'.EXT, array('plugin'=>URL_PLUGINS.$name.'/'), $___once);
  
}

function load_html($___path, array $___data=array(), $___once=false)
{
  
  static $file_checks = array();
  
  if(!in_array($___path, $file_checks)){
    if(is_file($___path)){
      $file_checks[] = $___path;
    }else{
      throw new \exception\FileMissing("Could not load contents of <b>$___path</b>. It is not a file.");
    }
  }
  
  elseif($___once===true){
    return '';
  }
  
  extract($___data);
  unset($___data);

  ob_start();
    require($___path);
    $contents = ob_get_contents();
  ob_end_clean();
  
  return $contents;

}

function files($pattern)
{
  $glob = glob($pattern);
  return (is_array($glob) ? $glob : array());
}
