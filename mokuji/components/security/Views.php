<?php namespace components\security; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected function settings_security()
  {
    
    return tx('Config')->user()
      
      ->having(
        'captcha_type',
        'tls_mode',
        'log_shared_login_sessions',
        'recaptcha_public_key',
        'recaptcha_private_key'
      )
      
      ->merge(array(
        'recaptcha_available' => plugin_available('recaptcha')
      ));
    
  }
  
}
