<?php namespace components\security; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $permissions = array(
      'generate_captcha' => 0,
      'validate_captcha' => 0,
      'reload_captcha_js' => 0
    );
  
  /**
   * Generates a CAPTCHA field based on the security settings.
   * 
   * @return string The generated HTML ready for inclusion into a form.
   */
  public function generate_captcha($options)
  {
    
    $hidden_field = t.t.'<input type="hidden" name="captcha_section" />'.n;
    
    switch(tx('Config')->user('captcha_type')->get()){
      
      case 'recaptcha':
        
        //This one is optional.
        if(!plugin_available('recaptcha'))
          throw new \exception\Programmer('reCAPTCHA plugin is not installed.');
        
        load_plugin('recaptcha');
        return recaptcha_get_html(tx('Config')->user('recaptcha_public_key')->get(), null)
          . $hidden_field;
      
      case 'captcha':
      case '':
      case null:
        return $this->section('generate_captcha_captcha', array('name'=>'securimage_captcha_response'))
          . $hidden_field;
      
      case 'disabled';
        return '';
      
      default:
        throw new \exception\Programmer('Captcha type "%s" does not exist.', tx('Config')->user('captcha_type')->get());
      
    }
    
  }
  
  /**
   * Validates a response based on the security settings.
   * 
   * @param array $options->form_data The complete form data returned.
   * @return boolean Whether the response was valid or not.
   */
  public function validate_captcha($options)
  {
    
    switch(tx('Config')->user('captcha_type')->get()){
      
      case 'recaptcha':
        
        //This one is optional.
        if(!plugin_available('recaptcha'))
          throw new \exception\Programmer('reCAPTCHA plugin is not installed.');
        
        load_plugin('recaptcha');
        return recaptcha_check_answer(
          tx('Config')->user('recaptcha_private_key')->get(),
          tx('Data')->server->REMOTE_ADDR->get(),
          $options->form_data->recaptcha_challenge_field->get(),
          $options->form_data->recaptcha_response_field->get()
        )->is_valid === true;
      
      case 'captcha':
      case '':
      case null:
        load_plugin('securimage');
        return \plugins\securimage\validate_response($options->form_data->securimage_captcha_response);
      
      case 'disabled';
        return true;
      
      default:
        throw new \exception\Programmer('Captcha type "%s" does not exist.', tx('Config')->user('captcha_type')->get());
      
    }
    
  }
  
  /**
   * Generates javascript code to dynamically reload the generated captcha. Useful for restForms.
   * @return string The generated javascript code to reload with.
   */
  public function reload_captcha_js()
  {
    
    switch(tx('Config')->user('captcha_type')->get()){
      
      case 'recaptcha':
        
        //This one is optional.
        if(!plugin_available('recaptcha'))
          throw new \exception\Programmer('reCAPTCHA plugin is not installed.');
        
        return ';Recaptcha.reload();';
      
      case 'captcha':
      case '':
      case null:
        return ';Securimage.reload();';
      
      case 'disabled';
        return true;
      
      default:
        throw new \exception\Programmer('Captcha type "%s" does not exist.', tx('Config')->user('captcha_type')->get());
      
    }
    
  }
  
}
