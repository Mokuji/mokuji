<?php

require_once('mokuji/system/dependencies/Initializer.php');
use \dependencies\Initializer;

$init = Initializer::get_instance();
$init->enable_debugging(true);

$env = isset($_SERVER['REDIRECT_MK_ENV']) ? $_SERVER['REDIRECT_MK_ENV'] : null;

switch($env){
  
  case 'admin':
    $init->set_environment(Initializer::ENV_BACKEND);
    break;
  
  case 'install':
    $init->set_environment(Initializer::ENV_INSTALL);
    break;
  
  case 'debug':
    $init->enable_debugging(true);
  
  default:
    $init->set_environment(Initializer::ENV_FRONTEND);
    break;
  
}

$init->run_environment();
