<?php namespace plugins\securimage; if(!TX) die('No direct access.');

function generate_url(){
  return URL_FRAMEWORK.'plugins/securimage/src/securimage_show.php';
}

function validate_response($response)
{
  
  raw($response);
  
  $_SESSION['securimage_code_disp'] = data_of(tx('Data')->session->securimage_code_disp);
  $_SESSION['securimage_code_value'] = data_of(tx('Data')->session->securimage_code_value);
  $_SESSION['securimage_code_ctime'] = data_of(tx('Data')->session->securimage_code_ctime);
  
  $SI = new \Securimage();
  return $SI->check($response);
  
}