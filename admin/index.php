<?php

//set variables
$error_handler      = 'error_handler';
$exception_handler  = 'exception_handler';

//indicate we're not installing
define('INSTALLING', false);

//initiate
require_once('../init.php');

//start session
tx('Session');

//initiate url class
tx('Url');

//enter a pageload log line
tx('Logging')->log('Core', 'Backend Pageload', tx('Url')->url->input, true);

//check account details and progress user activity
tx('Account');

//start filtering data
tx('Data');

//set language
tx('Language');

//define if the website is editable
define('EDITABLE', false);

//component singleton
tx('Component');

//config
tx('Config')->system('backend', true);
tx('Config')->system('component', 'cms');

//start doing stuff
tx('Router')->start();

//enter a pageload log line
tx('Logging')->log('Core', 'Backend Pageload', 'SUCCEEDED');
