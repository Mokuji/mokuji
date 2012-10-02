<?php
/*
 * CKFinder
 * ========
 * http://ckfinder.com
 * Copyright (C) 2007-2012, CKSource - Frederico Knabben. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
 */
//set variables

$error_handler      = 'error_handler';
$exception_handler  = 'exception_handler';

//initiate
require_once('../../../init.php');

//start session
tx('Session');

//initiate url class
tx('Url');

//check account details and progress user activity
tx('Account');

//start filtering data
tx('Data');

//page authorisation
tx('Account')->page_authorisation(2);

 
if ( version_compare( phpversion(), '5', '<' ) )
	require_once 'core/ckfinder_php4.php' ;
else
	require_once 'core/ckfinder_php5.php' ;
