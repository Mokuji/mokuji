<?php

//set variables
$error_handler      = 'error_handler';
$exception_handler  = 'exception_handler';

//indicate we're installing
define('INSTALLING', true);

//initiate
require_once('../init.php');

//start session
tx('Session');

//initiate url class
tx('Url');

//In case we already completed the installation, go to the backend.
if(file_exists('.completed'))
  tx('Url')->redirect('/admin/');

//enter a pageload log line
tx('Logging')->log('Core', 'Install Pageload', tx('Url')->url->input, true);

//start filtering data
tx('Data');

//check if the website is editable
tx('Editable');

//component singleton
tx('Component');

//config
tx('Config')->system('backend', true);
tx('Config')->system('component', 'update');

//start doing stuff
tx('Router')->start();

//enter a pageload log line
tx('Logging')->log('Core', 'Install Pageload', 'SUCCEEDED');

