<?php namespace components\account; if(!defined('TX')) die('No direct access.');

//Check we're not logged in.
if(!tx('Data')->session->user->check('login')){
  ?>
  
  <form method="POST" action="<?php echo url('rest=account/password_reset_request',1); ?>"  id="password_reset" class="login-form password-reset-form">
    
    <h1><?php __($names->component, 'Password forgotten'); ?></h1>
    
    <section>
      
      <div class="ctrlHolder clearfix">
        <p><?php __($names->component, 'PASSWORD_FORGOTTEN_INTRO_P1'); ?></p>
      </div>
      
      <div class="ctrlHolder clearfix">
        <label for="l_email"><?php __('E-mail address'); ?></label>
        <input id="l_email" type="text" name="email" value="" placeholder="<?php __('E-mail address'); ?>" />
      </div>
      
      <div class="ctrlHolder clearfix">
        <label><?php __('Security code'); ?></label>
        <?php echo $data->captcha; ?>
      </div>
      
      <div class="ctrlHolder clearfix">
        <input type="submit" name="login" value="<?php __($names->component, 'Recover'); ?>" />
      </div>
      
    </section>
    
  </form>
  
  <script type="text/javascript">
  jQuery(function($){
    
    $form = $('#password_reset');
    
    $form.restForm({
      
      success: function(result){
        
        //Clear fields.
        $form[0].reset();
        
        //Replace form content with result message.
        $form
          .empty()
          .text(result.message);
        
      },
      
      error: function(){
        
        //Hides the error message if validation errors are added to specific fields.
        if($form.find('.validation-error').size() > 0)
          $form.find('.restform-error-message').hide();
        
        //Reloads the captcha if needed.
        <?php echo $data->captcha_reload_js; ?>
        
      }
      
    })
    
    //Focus email input.
    $form.find(':input[name=email]').focus();
    
  });
  </script>
  
  <?php
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