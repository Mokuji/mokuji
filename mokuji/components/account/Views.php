<?php namespace components\account; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      
      'profile' => 0,
      'email_password_reset_no_account' => 0,
      'email_password_reset_token' => 0,
      'email_password_reset_complete' => 0,
      
      'claim_account' => 1
      
    );
  
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
    
    $is_logged_in = mk('Account')->isLoggedIn();
    if($is_logged_in){
      
      $user = mk('Sql')->table('account', 'Accounts')
        ->pk(mk('Account')->id)
        ->execute_single();
      
    }
    
    $has_media = mk('Component')->available('media');
    if($is_logged_in && $has_media){
      #TODO: Load image uploader plugin.
      #TODO: Load profile image.
    }
    
    return array(
      'has_media' => $has_media,
      'is_logged_in' => $is_logged_in,
      'login_form' => !$is_logged_in ? $this->section('login_form') : '',
      'profile' => $is_logged_in && !$user->is_empty() ? $this->module('user_profile') : ''
    );
    
  }
  
  protected function email_user_created()
  {
  
    return array();
    
  }
  
  protected function claim_account()
  {
    return array(
      'email' => mk('Account')->email,
      'username' => mk('Account')->username
    );
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
  
  protected function email_password_reset_no_account($options)
  {
    
    #TODO: Validation and defaults?
    return $options;
    
  }
  
  protected function email_password_reset_token($options)
  {
    
    #TODO: Validation and defaults?
    return $options;
    
  }
  
  protected function email_password_reset_complete($options)
  {
    
    #TODO: Validation and defaults?
    return $options;
    
  }
  
}
