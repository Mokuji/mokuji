<?php namespace dependencies\init;

require_once('Initializer.php');
require_once('Tasks.php');

/**
 * A static class that helps you to initialize Mokuji environments.
 */
abstract class Environments
{
  
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
      case Initializer::ENV_SHELL:
        throw new \Exception('The shell environment is not supported yet. If you have a usecase for it, please tell us.');
      
      //Frontend and backend currently have no requirements.
      case Initializer::ENV_FRONTEND:
      case Initializer::ENV_BACKEND:
        break;
      
      //Minimal and install implies no multi-site support by default.
      case Initializer::ENV_INSTALL:
      case Initializer::ENV_MINIMAL:
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
      Initializer::ENV_FRONTEND,
      Initializer::ENV_BACKEND,
      Initializer::ENV_INSTALL
    ))){
      
      //Handle errors and HTTP fixes.
      Tasks::register_error_handlers();
      Tasks::http_fixes();
      
      //Mention when we are in the backend(s).
      mk('Config')->system('backend', in_array($environment, array(
        Initializer::ENV_BACKEND,
        Initializer::ENV_INSTALL
      )));
      
      //Set our entrypoint.
      mk('Config')->system('component', $environment === Initializer::ENV_INSTALL ? 'update' : 'cms');
      
      //Initiate URL class.
      mk('Url');
      
      //Check if we are going to the installer when Mokuji is already installed.
      if($environment === Initializer::ENV_INSTALL && $init->is_installed()){
        mk('Url')->redirect('/admin/');
        mk('Router')->start();
        return;
      }
      
      //Also make sure we're not going to anywhere else HTTP(S) based when Mokuji is not installed.
      elseif($environment !== Initializer::ENV_INSTALL && !$init->is_installed()) {
        mk('Url')->redirect('/install/');
        mk('Router')->start();
        return;
      }
      
    }
    
    //Finalize specific environment things.
    switch($environment){
      
      case Initializer::ENV_MINIMAL:
        mk('Logging')->log('Core', 'Minimal environment', 'Initialized from: '. (defined('WHOAMI') ? WHOAMI : 'an unknown source'), true);
        break;
      
      case Initializer::ENV_FRONTEND:
      case Initializer::ENV_BACKEND:
        
        $title = $environment === Initializer::ENV_BACKEND ? 'Backend' : 'Frontend';
        
        //enter a pageload log line
        mk('Logging')->log('Core', $title.' pageload', mk('Url')->url->input, true);
        
        mk('Account');    //check account details and progress user activity
        mk('Data');       //start filtering data
        mk('Language');   //set language
        mk('Editable');   //check if the website is editable
        mk('Component');  //component singleton
        
        //start doing stuff
        mk('Router')->start();
        
        //enter a pageload log line
        mk('Logging')->log('Core', $title.' pageload', 'SUCCEEDED');
        
        break;
      
      case Initializer::ENV_INSTALL:
        
        //enter a pageload log line
        mk('Logging')->log('Core', 'Install Pageload', mk('Url')->url->input, true);
        
        mk('Data');       //start filtering data
        mk('Editable');   //check if the website is editable
        mk('Component');  //component singleton
        
        //start doing stuff
        mk('Router')->start();
        
        //enter a pageload log line
        mk('Logging')->log('Core', 'Install pageload', 'SUCCEEDED');
        
        break;
      
    }
    
  }
  
}