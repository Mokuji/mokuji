<?php namespace components\security; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected
    $permissions = array(
      'generate_captcha_captcha' => 0
    );
  
  protected function generate_captcha_captcha($options)
  {
    
    load_plugin('securimage');
    
    return array(
      'url' => \plugins\securimage\generate_url(),
      'name' => $options->name->otherwise('captcha_response')
    );
    
  }
  
}
