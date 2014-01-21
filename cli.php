<?php

define('WHOAMI', 'Mokuji CLI');

//Add some workarounds.
$_SERVER['DOCUMENT_ROOT'] = getcwd();
$_SERVER['HTTP_HOST'] = 'localhost';

require_once('mokuji/system/dependencies/init/Initializer.php');
use \dependencies\init\Initializer;
use \dependencies\init\Environments;
$init = Initializer::get_instance();

//Comment on live sites.
$init->enable_debugging(true);

//Use a minimal environment.
$init->set_environment(Environments::MINIMAL);

//Load our stuff.
$init->run_environment();

//Pretend to be ADMIN.
mk('Account')->user->set(array(
  'login' => true,
  'level' => 2,
  'username' => '[SHELL_USER]'
));

//Do some routing: component action [arg1, arg2, ..., argN]
if(empty($argv[1]) || empty($argv[2]))
  die('Usage: php cli.php component action [arg1, arg2, ..., argN]'.n);

array_shift($argv); //Script name.
$component = array_shift($argv);
$action = array_shift($argv);

//GO GO GO!
try{
  mk('Component')->actions($component)->call($action, $argv);
}

catch(\exception\Exception $ex){
  die($ex->getMessage().n);
}