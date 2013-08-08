<?php namespace components\update\tasks; if(!defined('TX')) die('No direct access.');

abstract class CoreUpdates
{
  
  static protected $cores;
  
  /*
    Core codenames in order of age, lower value is older.
    For definitions, see http://development.mokuji.org/60/core-codenames?menu=62
  */
  const
    CORE_ADEPT_ALBATROSS = 1,
    CORE_BALLISTIC_BADGER = 2;
  
  /**
   * Indicates whether or not the current setup needs a core upgrade.
   * @return boolean
   */
  public static function need_core_upgrade()
  {
    
    //If the new core (currently executing) indicates it is installed, we assume merging has been done.
    if(!INSTALLING)
      return false;
    
    //Detect cores present in order of age.
    $cores = self::detect_cores();
    
    //If the latest core is present but not alone, it should be upgraded.
    if(array_key_exists(self::CORE_BALLISTIC_BADGER, $cores))
      return count($cores) > 1;
    
    /*
      The latest core is not detected at all.
      That is a problem because when the constant for the latest core is defined, that means
      this class has been coded for a newer core than is currently running.
      Most likely this is due to an incomplete upload of the new core files.
    */
  throw new \exception\Programmer(
    'The CoreUpdates tasks are written for the Ballistic Badger core, but this core was not detected. '.
    'This could indicate some files were incorrectly uploaded.'
  );
    
  }
  
  /**
   * Detects cores present in order of age and whether they are marked as installed.
   * @return array The present cores in order of age.
   */
  public static function detect_cores()
  {
    
    if(isset(self::$cores))
      return self::$cores;
    
    $cores = array();
    
    //Detect: Adept Albatross
    if(file_exists(PATH_BASE.DS.'init.php'))
      $cores[self::CORE_ADEPT_ALBATROSS] = file_exists(PATH_BASE.DS.'install'.DS.'.completed');
    
    //Detect: Ballistic Badger
    if(file_exists(PATH_BASE.DS.'mokuji'.DS.'system'.DS.'dependencies'.DS.'init'.DS.'Initializer.php'))
      $cores[self::CORE_BALLISTIC_BADGER] = file_exists(PATH_BASE.DS.'mokuji'.DS.'.completed-install');
    
    self::$cores = $cores;
    
    //This is the kind of thing that you would like to be kept informed of when tracing problems.
    mk('Logging')->log('CoreUpdates', 'Detected cores', Data($cores)->dump());
    
    return $cores;
    
  }
  
  #TODO
  public static function suggest_file_transfer_actions()
  {
    
    //Note that this is only for Adept Albatross -> Ballistic Badger. Will need tweaking later.
    
    $actions = array();
    
    #Plugins
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'plugins'.DS.'%s',
      PATH_PLUGINS.DS.'%s',
      'DELETE'
    ));
    
    #Components
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'site'.DS.'components'.DS.'%s',
      PATH_COMPONENTS.DS.'%s',
      'MERGE'
    ));
    
    #Templates
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'site'.DS.'templates'.DS.'%s',
      PATH_TEMPLATES.DS.'%s',
      'DELETE'
    ));
    
    #Themes
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'site'.DS.'themes'.DS.'%s',
      PATH_THEMES.DS.'%s',
      'DELETE'
    ));
    
    #Logs
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'logs',
      PATH_FRAMEWORK.DS.'logs',
      'MERGE'
    ));
    
    #Cleanup
    $actions = array_merge($actions, self::detect_deletables(array(
      PATH_BASE.DS.'.package',
      PATH_BASE.DS.'admin',
      PATH_BASE.DS.'apidocs',
      PATH_BASE.DS.'config',
      PATH_BASE.DS.'install',
      PATH_BASE.DS.'tools',
      PATH_BASE.DS.'init.php',
      PATH_BASE.DS.'phpdoc.dist.xml'
    )));
    
    return $actions;
    
  }
  
  #TODO
  #Returns true if clean.
  protected static function detect_clean_moves($source_format, $target_format, $fallback)
  {
    
    $actions = array();
    
    $source_extract = '~^'.sprintf($source_format, '([^\\'.DS.']+)').'$~';
    $sources = glob(sprintf($source_format, '*'));
    foreach($sources as $source){
      
      if(!preg_match($source_extract, $source, $matches))
        throw new \exception\Exception('Unable to match name in '.$source.' with pattern '.$source_extract);
      
      $name = isset($matches[1]) ? $matches[1] : null;
      $target = sprintf($target_format, $name);
      
      if(!file_exists($source))
        throw new \exception\Exception('Matched '.$source.' but it does not exist? Weird...');
      
      $clean = !file_exists($target);
      $action = $clean ? 'MOVE' : strtoupper($fallback);
      $actions[] = array(
        'source' => self::strip_base($source),
        'target' => $action === 'DELETE' ? '-' : self::strip_base($target),
        'action' => $action,
        'details' => $clean ? 
          'Can be cleanly moved.' :
          'Already exists in target.'
      );
      
    }
    
    return $actions;
    
  }
  
  #TODO
  #Returns which of these exists and returns the delete actions.
  protected static function detect_deletables(array $locations)
  {
    
    $actions = array();
    
    foreach ($locations as $location){
      
      if(file_exists($location))
        $actions[] = array(
          'source' => self::strip_base($location),
          'target' => '-',
          'action' => 'DELETE',
          'details' => 'No longer needed.'
        );
      
    }
    
    return $actions;
    
  }
  
  #TODO
  protected static function strip_base($input)
  {
    return str_replace(PATH_BASE.DS, './', $input);
  }
  
}