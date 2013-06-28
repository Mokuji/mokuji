<?php

require_once('mokuji/system/dependencies/init/Initializer.php');
use \dependencies\init\Initializer;
$init = Initializer::get_instance();

//Comment on live sites.
$init->enable_debugging(true);

//Get the environment definition from any rewrite rules.
$env = isset($_SERVER['REDIRECT_MK_ENV']) ? $_SERVER['REDIRECT_MK_ENV'] : null;

switch($env){
  
  case 'admin':
    $init->set_environment(Initializer::ENV_BACKEND);
    break;
  
  case 'install':
    $init->set_environment(Initializer::ENV_INSTALL);
    break;
  
  /*
    Assume front-end by default, because this IS the Mokuji index.php.
    This means you should not try to use it for a minimal environment.
  */
  default:
    $init->set_environment(Initializer::ENV_FRONTEND);
    break;
  
}

//Go for it!
$init->run_environment();
