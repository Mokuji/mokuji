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
    if(file_exists(PATH_BASE.DS.'init.php') || file_exists(PATH_BASE.DS.'config'.DS.'database.php'))
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
    
    #Files
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'files',
      PATH_FRAMEWORK.DS.'files',
      'MERGE'
    ));
    
    #Logs
    $actions = array_merge($actions, self::detect_clean_moves(
      PATH_BASE.DS.'logs',
      PATH_FRAMEWORK.DS.'logs',
      'MERGE'
    ));
    
    #Stuff we don't need in any case
    $actions = array_merge($actions, self::detect_deletables(array(
      PATH_BASE.DS.'.package',
      PATH_BASE.DS.'admin',
      PATH_BASE.DS.'apidocs',
      PATH_BASE.DS.'config',
      PATH_BASE.DS.'install',
      PATH_BASE.DS.'tools',
      PATH_BASE.DS.'phpdoc.dist.xml',
      PATH_BASE.DS.'init.php' //Do this last, so the core detection works longer.
    )));
    
    #Stuff that should only be deleted when no other messages related to this are left
    $actions = array_merge($actions, self::detect_deletables(array(
      PATH_BASE.DS.'plugins',
      PATH_BASE.DS.'site'
    ), true));
    
    return $actions;
    
  }
  
  #TODO
  #Returns true if all actions are completed.
  public static function execute_file_transfer_actions(\dependencies\Data $files)
  {
    
    $post_deletes = Data();
    
    $files->each(function($file, $index)use($post_deletes){
      
      //Skip the ones that don't have the execute flag.
      if(!$file->execute->validate('Execute', array('boolean'))->is_true())
        return;
      
      try{
        
        switch(strtoupper($file->action->get('string')))
        {
          
          case 'MOVE':
            mk('Logging')->log('CoreUpdates', 'MOVE', $file->source.' => '.$file->target);
            if(!rename(
              self::add_base($file->source),
              self::add_base($file->target)
            )) throw new \Exception("Moving failed.");
            break;
          
          case 'MERGE':
            mk('Logging')->log('CoreUpdates', 'MERGE', $file->source.' => '.$file->target);
            if(!recursive_move(
              self::add_base($file->source),
              self::add_base($file->target),
              'target' //Preserve files in target, because we assume the new core is always more important.
            )) throw new \Exception("Merge failed.");
            break;
          
          case 'DELETE':
            mk('Logging')->log('CoreUpdates', 'DELETE', $file->source);
            if(!recursive_delete(self::add_base($file->source)))
              throw new \Exception("Deleting failed.");
            break;
          
          //Postpone these to process them last.
          case 'POST-DELETE':
            mk('Logging')->log('CoreUpdates', 'POST-DELETE', $file->source.' (queued)');
            $post_deletes->merge(array(
              $index => $file
            ));
            break;
          
          default:
            throw new \Exception("This action is not implemented");
            break;
          
        }
        
      } catch(\Exception $ex) {
        $vex = new \exception\Validation("Action failed.");
        $vex->key("files[$index][source]");
        $vex->errors(array($ex->getMessage()));
        throw $vex;
      }
      
    });
    
    //Check for post-deletes.
    if($post_deletes->size() > 0){
      
      //For each post-delete...
      $post_deletes->each(function($file, $index){
        
        //Map the remaining suggestions.
        $suggestions = self::suggest_file_transfer_actions();
        
        try{
          
          //Detect if it conflicts with the suggestions.
          $conflict_string = $file->source->get('string');
          $len = strlen($conflict_string);
          
          foreach($suggestions as $suggestion){
            
            //If the start of the string matches, it seems like a conflict.
            if(substr($suggestion['source'], 0, $len) == $conflict_string){
              
              //Except when it's an exact match and the action is POST-DELETE. Then we found the current action.
              if($suggestion['action'] != 'POST-DELETE' && $suggestion['source'] != $conflict_string){
                mk('Logging')->log('CoreUpdates', 'POST-DELETE', 'Suggestion match. '.$suggestion['source'].' => '.$conflict_string);
                throw new \exception\Exception('Suggestions still remaining for this location');
              }
              
            }
            
          }
          
          //Since no conflict have thrown an exception, proceed with deleting.
          mk('Logging')->log('CoreUpdates', 'POST-DELETE', $file->source);
          if(!recursive_delete(self::add_base($file->source)))
            throw new \Exception("Deleting of POST-DELETE failed.");
          
        } catch(\Exception $ex) {
          $vex = new \exception\Validation("Action failed.");
          $vex->key("files[$index][source]");
          $vex->errors(array($ex->getMessage()));
          throw $vex;
        }
        
      });
      
    }
    
    return true;
    
  }
  
  #TODO
  public static function replace_file_references($input, &$matched)
  {
    
    raw($input);
    
    $old_url = URL_BASE.'files/';
    $new_url = URL_FRAMEWORK.'files/';
    
    $output = preg_replace_callback(
      '~(src|href)="'.$old_url.'([^"]+)"~',
      function($matches)use($new_url){
        return $matches[1].'="'.$new_url.$matches[2].'"';
      },
      $input,
      -1, //No limit.
      $matched
    );
    
    return $output;
    
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
        throw new \exception\Exception('Matched '.$source.' with glob but it does not exist? Weird...');
      
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
  protected static function detect_deletables(array $locations, $post_delete=false)
  {
    
    $actions = array();
    
    foreach ($locations as $location){
      
      if(file_exists($location))
        $actions[] = array(
          'source' => self::strip_base($location),
          'target' => '-',
          'action' => $post_delete ? 'POST-DELETE' : 'DELETE',
          'details' => $post_delete ?
            'When everything is done in this folder, it\'s no longer needed.' :
            'No longer needed.',
        );
      
    }
    
    return $actions;
    
  }
  
  #TODO
  protected static function strip_base($input){
    raw($input);
    return str_replace(PATH_BASE.DS, './', $input);
  }
  
  #TODO
  protected static function add_base($input){
    raw($input);
    if(substr($input, 0, 2) === './')
      return PATH_BASE.DS.substr($input, 2);
  }
  
}