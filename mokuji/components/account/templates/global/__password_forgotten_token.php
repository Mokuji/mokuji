<?php namespace components\account; if(!defined('TX')) die('No direct access.');

//Check we're not logged in.
if(!tx('Data')->session->user->check('login')){
  
  //Did the token turn out valid?
  if($data->is_valid->is_true()){
    
    echo load_plugin('jquery_password_strength');
    
    ?>
    
    <form method="POST" action="<?php echo url('rest=account/password_reset_finalization',1); ?>"  id="password_reset" class="login-form password-reset-form">
      
      <h1><?php __($names->component, 'Set new password'); ?></h1>
      
      <section>
        
        <?php /* Future option: add second factor to do 2FA or use secret question. */ ?>
        
        <input type="hidden" name="token" value="<?php echo $data->token; ?>" />
        
        <!-- This is for some password managers to auto-update correctly -->
        <input type="hidden" name="email" value="<?php echo $data->email; ?>" />
        
        <div class="ctrlHolder clearfix">
          <p><?php echo transf($names->component, 'You can now enter a new password for e-mail: {0}', $data->email); ?></p>
        </div>
        
        <div class="ctrlHolder clearfix">
          <label for="l_password1"><?php __($names->component, 'New password'); ?></label>
          <input id="l_password1" type="password" name="password1" value="" placeholder="<?php __($names->component, 'New password'); ?>" />
        </div>
        
        <div class="ctrlHolder clearfix">
          <label for="l_password2"><?php __($names->component, 'Confirm new password'); ?></label>
          <input id="l_password2" type="password" name="password2" value="" placeholder="<?php __($names->component, 'Confirm new password'); ?>" />
        </div>
        
        <div class="ctrlHolder clearfix">
          <input type="submit" name="login" value="<?php __($names->component, 'Set password'); ?>" />
        </div>
        
      </section>
      
    </form>
    
    <form method="GET" action="<?php echo url('/',1); ?>"  id="operation_result" class="login-form modal-operation-result-form" style="display:none;">
      
      <h1><?php __($names->component, 'Password has been set'); ?></h1>
      
      <section>
        
        <div class="ctrlHolder clearfix">
          <p class="message-p"></p>
        </div>
        
        <div class="ctrlHolder clearfix">
          <input type="submit" value="<?php __('OK'); ?>" />
        </div>
        
      </section>
      
    </form>
    
    <script type="text/javascript">
    jQuery(function($){
      
      $form = $('#password_reset');
      
      $form.find('#l_password1').PasswordStrength();
      
      $form.restForm({
        
        beforeSubmit: function(){
        
          //Disable form to prevent submitting more than once.
          $form.find('input[type="submit"]').attr('disabled', 'disabled');
          
        },
        
        success: function(result){
          
          $form.hide();
          $operation_result = $('#operation_result');
          $operation_result.find('.message-p').text(result.message);
          $operation_result.show();
          
        },
        
        error: function(){
          
          //Hides the error message if validation errors are added to specific fields.
          if($form.find('.validation-error').size() > 0)
            $form.find('.restform-error-message').hide();
          
          //Re-enable the form to try again.
          $form.find('input[type="submit"]').removeAttr('disabled');
          
        }
        
      })
      
      //Focus email input.
      $form.find(':input[name=email]').focus();
      
    });
    </script>
    
    <?php
    
  }
  
  //Otherwise display an error.
  else{
    ?>
    <form method="GET" action="<?php echo url('/',1); ?>"  id="operation_result" class="login-form modal-operation-result-form">
      
      <h1><?php __($names->component, 'Token is invalid'); ?></h1>
      
      <section>
        
        <div class="ctrlHolder clearfix">
          <p><?php __($names->component, 'PASSWORD_RECOVERY_TOKEN_INVALID_P1'); ?></p>
        </div>
        
        <div class="ctrlHolder clearfix">
          <input type="submit" value="<?php __('OK'); ?>" />
        </div>
        
      </section>
      
    </form>
    <?php
  }
  
}


//Already logged in.
else{
  ?>
  
  <script type="text/javascript">
    document.location = '<?php echo url(URL_BASE.'?'.tx('Config')->user('homepage'), true); ?>';
  </script>
  
  <p>
    <?php __($names->component, 'Welcome back'); ?>!<br />
    <a href="<?php echo url(URL_BASE.'?'.tx('Config')->user('homepage'), true); ?>"><?php __($names->component, 'Go to the homepage.'); ?></a>
  </p>
  
  <?php 
}