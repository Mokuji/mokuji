<?php namespace components\security; if(!defined('TX')) die('No direct access.'); ?>

<p class="settings-description"><?php __($names->component, 'SETTINGS_SECURITY_VIEW_DESCRIPTION'); ?></p>

<form id="edit_security_settings_form" class="form edit-security-settings-form" method="PUT" action="<?php echo url('rest=cms/settings', true); ?>">
  
  <div class="ctrlHolder">
    
    <label for="l_captcha_type">Captcha configuration</label>
    <select id="l_captcha_type" name="captcha_type[default]">
      
      <?php $data->recaptcha_available->is('true', function()use($data, $names){ ?>
        <option value="recaptcha"<?php if($data->captcha_type->get() == 'recaptcha') echo ' selected="selected"'; ?>><?php __($names->component, 'reCAPTCHA'); ?></option>
      <?php }); ?>
      
      <option value="captcha"<?php if($data->captcha_type->is_empty() || $data->captcha_type->get() == 'captcha') echo ' selected="selected"'; ?>><?php __($names->component, 'Default captcha'); ?></option>
      <option value="disabled"<?php if($data->captcha_type->get() == 'disabled') echo ' selected="selected"'; ?>><?php __($names->component, 'Disabled'); ?></option>
    </select>
    
    <?php $data->recaptcha_available->is('true', function()use($data, $names){ ?>
      
      <label for="l_recaptcha_public_key">reCAPTCHA public key</label>
      <input type="text" id="l_recaptcha_public_key" name="recaptcha_public_key[default]" value="<?php echo $data->recaptcha_public_key; ?>" />
      
      <label for="l_recaptcha_private_key">reCAPTCHA private key</label>
      <input type="text" id="l_recaptcha_private_key" name="recaptcha_private_key[default]" value="<?php echo $data->recaptcha_private_key; ?>" />
      
    <?php }); ?>
    
  </div>
  
  <div class="ctrlHolder">
    <label for="l_tls_mode"><?php __($names->component, 'TLS mode'); ?></label>
    <select id="l_tls_mode" name="tls_mode[default]">
      <option value="always"<?php if($data->tls_mode->get() == 'always') echo ' selected="selected"'; ?>><?php __($names->component, 'Always enforce'); ?></option>
      <option value="logged-in"<?php if($data->tls_mode->get() == 'logged-in') echo ' selected="selected"'; ?>><?php __($names->component, 'Enforce on login'); ?></option>
      <option value=""<?php if($data->tls_mode->is_empty()) echo ' selected="selected"'; ?>><?php __($names->component, 'Automatic detection'); ?></option>
      <option value="never"<?php if($data->tls_mode->get() == 'never') echo ' selected="selected"'; ?>><?php __($names->component, 'Never use TLS'); ?></option>
    </select>
  </div>
  
  <div class="ctrlHolder">
    <label><?php __($names->component, 'Logging'); ?>
    <label>
      <input type="checkbox" name="log_shared_login_sessions[default]" value="1"<?php if($data->log_shared_login_sessions->get()) echo ' checked="checked"'; ?> />
      <?php __($names->component, 'Log shared login sessions'); ?>
    </label>
  </div>
  
  <div class="buttonHolder">
    <input type="submit" class="primaryAction button black" value="<?php __('Save'); ?>" />
  </div>
  
</form>

<script type="text/javascript">
jQuery(function($){
  $('#edit_security_settings_form').restForm();
});
</script>