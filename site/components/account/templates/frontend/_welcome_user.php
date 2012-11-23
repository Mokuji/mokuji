<?php namespace components\account; if(!defined('TX')) die('No direct access.');

echo __($names->component, 'Welcome').', '.$welcome_user->email;
