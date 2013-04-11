<?php

//set variables
$error_handler      = 'error_handler';
$exception_handler  = 'exception_handler';

//Store old vars.
$oldvars = array(
  'post'=>$_POST,
  'get'=>$_GET,
  'request'=>$_REQUEST,
  'session'=>((isset($_SESSION) && is_array($_SESSION)) ? $_SESSION : array()),
  'server'=>$_SERVER,
  'files'=>$_FILES,
  'env'=>$_ENV,
  'cookie'=>$_COOKIE
);

//indicate we're not installing
define('INSTALLING', false);

//initiate
require_once(dirname(__FILE__).'/../init.php');

//start session
tx('Session');

//enter a pageload log line
tx('Logging')->log('Core', 'Backend require admin', 'From: '. (defined('WHOAMI') ? WHOAMI : 'an unknown source'), true);

//check account details and progress user activity
tx('Account');

//check for admin.
if(!tx('Account')->check_level(2)){
  throw new \Exception("You need to be logged in as admin to use this function.");
}

//Revert old vars.
$_POST = $oldvars['post'];
$_GET = $oldvars['get'];
$_REQUEST = $oldvars['request'];
$_SESSION = $oldvars['session'];
$_SERVER = $oldvars['server'];
$_FILES = $oldvars['files'];
$_ENV = $oldvars['env'];
$_COOKIE = $oldvars['cookie'];
