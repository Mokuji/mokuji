<?php namespace components\account; if(!defined('TX')) die('No direct access.');

//Not logged in. Show login form.
if(!$data->is_logged_in->is_true()){
  echo $data->login_form;
}

//Logged in. Show profile.
else{
  echo $data->profile;
}
