<?php namespace components\account; if(!defined('TX')) die('No direct access.');

//append user object for easy access
$user =& tx('Data')->session->user;

//validate login
if(!$user->check('login')):

?>

<form method="POST" action="<?php echo url('rest=account/user_session',1); ?>"  id="login_form" class="login-form">
  
  <h1><?php __('LOGIN_VERB'); ?></h1>
  
  <?php echo $messages->error; ?>
  
  <section>
    
    <input type="hidden" name="target_url" value="<?php echo $options->target_url; ?>" />
    
    <div class="ctrlHolder clearfix">
      <label for="l_username"><?php __('Username'); ?></label>
      <input id="l_username" type="text" name="email" value="<?php echo tx('Data')->post->email->otherwise(tx('Data')->get->email); ?>" placeholder="<?php __('Username'); ?>" />
    </div>
    
    <div class="ctrlHolder clearfix">
      <label for="l_password"><?php __('Password'); ?></label>
      <input id="l_password" type="password" name="password" value="" placeholder="<?php __('Password'); ?>" />
    </div>
    
    <div class="ctrlHolder clearfix">
      <input id="l_remember" type="checkbox" name="persistent" value="1" />
      <!-- #TODO: In-line style attribute. :( -->
      <label for="l_remember" style="display:inline-block"><?php __('Remember me'); ?></label>
    </div>
    
    <div class="ctrlHolder clearfix">
      <a class="tx-link password-forgotten" href="<?php echo url('?password_forgotten=init', true); ?>"><?php __('account', 'Password forgotten'); ?></a>
      <input type="submit" name="login" value="<?php __('LOGIN_VERB'); ?>" />
    </div>
    
  </section>
  
  <script type="text/javascript">
    jQuery(function($){
      
      $('#login_form').restForm({
        
        success: function(result){
          
          if(result.success === true)
            window.location = result.target_url;
          
        },
        
        error: function(err){
          $('#l_password').val('');
          $('#l_username').focus().select();
        }
        
      });
      
      <?php if($options->autofocus->is_true()): ?>
        $('#login_form').find('#l_username').focus();
      <?php endif; ?>
      
    });
  </script>
  
</form>

<?php 

//If the user is not logged in.
else:

?>

<script type="text/javascript">
window.location = '<?php echo url(URL_BASE.'?'.tx('Config')->user('homepage'), true); ?>';
</script>

<p>
  <?php __($names->component, 'Welcome back'); ?>!<br />
  <a href="<?php echo url(URL_BASE.'?'.tx('Config')->user('homepage'), true); ?>"><?php __($names->component, 'Go to the homepage.'); ?></a>
</p>

<?php

endif;
