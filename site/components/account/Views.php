<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{

  protected function accounts()
  {
    
    return array(
      'users' => $this->section('user_list'),
      'new_user' => $this->section('edit_user'),
      'new_group' => $this->section('edit_user_group')
    );
    
  }
  
  protected function user()
  {
    
    return $this->section('edit_user');
    
  }

  protected function profile()
  {
    
    return array(
      'login_form' => $this->section('login_form'),
      'profile' => $this->section('profile')
    );
    
  }
  
  protected function email_user_created()
  {
  
    return array();
    
  }
  
  protected function email_user_invited($options)
  {
    
    //>>TODO Validation and defaults?
    return $options;
    
  }
  
  protected function email_user_password_reset($options)
  {
    
    //>>TODO Validation and defaults?
    return $options;
    
  }
  
}
