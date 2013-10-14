<?php namespace dependencies\init;

require_once('Initializer.php');
require_once('Tasks.php');

/**
 * A static class that helps you to initialize Mokuji environments.
 */
abstract class Environments
{
  
  /**
   * Shell environment.
   */
  const SHELL = 0;
  
  /**
   * Frontend environment.
   */
  const FRONTEND = 1;
  
  /**
   * Backend environment.
   */
  const BACKEND = 2;
  
  /**
   * Install environment.
   */
  const INSTALL = 3;
  
  /**
   * Minimal environment.
   */
  const MINIMAL = 4;
  
  /**
   * REST environment.
   */
  const REST = 5;
  
  /**
   * Performs verifications and operations before setting an environment.
   * @param  Initializer $init The initializer calling this function.
   * @param  integer $environment The environment that has been set.
   * @return void
   */
  public static function on_set(Initializer $init, $environment)
  {
    
    switch($environment){
      
      #TODO: Build shell support.
      case self::SHELL:
        throw new \Exception('The shell environment is not supported yet. If you have a usecase for it, please tell us.');
      
      //Environments without requirements.
      case self::FRONTEND:
      case self::BACKEND:
      case self::REST:
        break;
      
      //Minimal and install implies no multi-site support by default.
      case self::INSTALL:
      case self::MINIMAL:
        $init->enable_multisite(false);
        break;
      
      default:
        throw new \Exception('Unknown environment: '.$environment);
      
    }
    
  }
  
  /**
   * Performs environment specific logic to be performed when running an environment.
   * @param  Initializer $init The initializer calling this function.
   * @param  integer $environment The environment that has been set.
   * @return void
   */
  public static function on_run(Initializer $init, $environment)
  {
    
    //Start session.
    mk('Session');
    
    //For Mokuji handled, HTTP(S) based environments only.
    if(in_array($environment, array(
      self::FRONTEND,
      self::BACKEND,
      self::INSTALL
    ))){
      
      //Handle errors and HTTP fixes.
      Tasks::register_error_handlers($environment);
      Tasks::http_fixes();
      
      //Mention when we are in the backend(s).
      mk('Config')->system('backend', in_array($environment, array(
        self::BACKEND,
        self::INSTALL
      )));
      
      //Set our entrypoint.
      switch($environment)
      {
        case self::INSTALL:
          $entrypoint = 'update';
          break;
        case self::FRONTEND:
          $entrypoint = ENTRYPOINT_FRONTEND;
          break;
        case self::BACKEND:
          $entrypoint = ENTRYPOINT_FRONTEND;
          break;
        default:
          $entrypoint = 'cms';
          break;
      }
      mk('Config')->system('component', $entrypoint);

      //Initiate URL class.
      mk('Url');
      
      //Check if we are going to the installer when Mokuji is already installed.
      if($environment === self::INSTALL && $init->is_installed()){
        mk('Url')->redirect('/admin/');
        mk('Router')->start();
        return;
      }
      
      //Also make sure we're not going to anywhere else HTTP(S) based when Mokuji is not installed.
      elseif($environment !== self::INSTALL && !$init->is_installed()) {
        mk('Url')->redirect('/install/');
        mk('Router')->start();
        return;
      }
      
    }
    
    //Finalize specific environment things.
    switch($environment){
      
      case self::MINIMAL:
        mk('Logging')->log('Core', 'Minimal environment', 'Initialized from: '. (defined('WHOAMI') ? WHOAMI : 'an unknown source'), true);
        break;
      
      case self::REST:
        
        //Handle errors and HTTP fixes.
        Tasks::register_error_handlers($environment);
        Tasks::http_fixes();
        
        //Set that we're not in the backend, but we don't need to set an entrypoint.
        mk('Config')->system('backend', false);
        
        //Initiate URL class.
        mk('Url');
        
        //Log this call.
        $query_string = http_build_query(mk('Data')->get->without('_RESTROUTE')->as_array());
        $query_string = $query_string ? '?'.$query_string : '';
        mk('Logging')->log('Core', 'REST call', mk('Data')->get->_RESTROUTE.$query_string, true);
        
        mk('Account');    //Check account details and progress user activity
        mk('Language');   //Set language
        mk('Component');  //Component singleton
        
        //Start doing stuff
        mk('Router')->rest();
        
        //Log this call.
        mk('Logging')->log('Core', 'REST call', 'SUCCEEDED');
        
        break;
      
      case self::FRONTEND:
      case self::BACKEND:
        
        $title = $environment === self::BACKEND ? 'Backend' : 'Frontend';
        
        //Enter a pageload log line
        mk('Logging')->log('Core', $title.' pageload', mk('Url')->url->input, true);
        
        mk('Account');    //check account details and progress user activity
        mk('Data');       //start filtering data
        mk('Language');   //set language
        mk('Editable');   //check if the website is editable
        mk('Component');  //component singleton
        
        //start doing stuff
        mk('Router')->start();
        
        //Enter a pageload log line
        mk('Logging')->log('Core', $title.' pageload', 'SUCCEEDED');
        
        break;
      
      case self::INSTALL:
        
        //Enter a pageload log line
        mk('Logging')->log('Core', 'Install Pageload', mk('Url')->url->input, true);
        
        mk('Data');       //start filtering data
        mk('Editable');   //check if the website is editable
        mk('Component');  //component singleton
        
        //start doing stuff
        mk('Router')->start();
        
        //Enter a pageload log line
        mk('Logging')->log('Core', 'Install pageload', 'SUCCEEDED');
        
        break;
      
    }
    
  }
  
}