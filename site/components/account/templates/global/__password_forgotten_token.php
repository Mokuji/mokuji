<?php namespace components\account; if(!defined('TX')) die('No direct access.');

//Check we're not logged in.
if(!tx('Data')->session->user->check('login')){
  
  //Did the token turn out valid?
  if($data->is_valid->is_true()){
    
    ?>
    
    <form method="POST" action="<?php echo url('rest=account/password_reset_finalization',1); ?>"  id="password_reset" class="login-form password-reset-form">
      
      <h1><?php __('Set new password'); ?></h1>
      
      <section>
        
        <?php /* Future option: add second factor to do 2FA or use secret question. */ ?>
        
        <input type="hidden" name="token" value="<?php echo $data->token; ?>" />
        
        <!-- This is for some password managers to auto-update correctly -->
        <input type="hidden" name="email" value="<?php echo $data->email; ?>" />
        
        <div class="ctrlHolder clearfix">
          Now you can set a new password for e-mail: <?php echo $data->email; ?>
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
    
    <script type="text/javascript">
    jQuery(function($){
      
      $form = $('#password_reset');
      
      $form.restForm({
        
        success: function(result){
          
          window.location = '<?php echo url("/admin/", true); ?>';
          
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
    <form method="GET" action="<?php echo url('/',1); ?>"  id="password_reset" class="login-form password-reset-form">
      
      <h1><?php __('Token is invalid'); ?></h1>
      
      <section>
        
        <div class="ctrlHolder clearfix">
          <p>
            Your token is no good bro.
            Keep in mind tokens are only usable once and valid for one hour.
            Try restarting the process.
          </p>
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