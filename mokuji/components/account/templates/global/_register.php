<?php namespace components\account; if(!defined('TX')) die('No direct access.');
$uid = mk('Security')->random_string(10);
echo load_plugin('jquery_rest');
?>

<?php if(!$data->check('logged_in')): ?>
  
  <section class="account-registration module">
    
    <h1>Register form</h1>
    
    <form method="POST" action="<?php echo url('?rest=account/new_account'); ?>" id="register_form_<?php echo $uid; ?>" class="account-registration-form form">
      
      <div class="ctrlHolder">
        <label for="l_email">Email</label>
        <input id="l_email" type="text" name="email" placeholder="Email" />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_password1">Password</label>
        <input id="l_password1" type="password" name="password1" placeholder="Password" />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_password2">Confirm password</label>
        <input id="l_password2" type="password" name="password2" placeholder="Confirm password" />
      </div>
      
      <?php echo $data->captcha; ?>
      
      <div class="buttonHolder">
        <input type="submit" value="Register" class="button primaryAction" />
      </div>
      
    </form>
    
    <script type="text/javascript">
      jQuery(function($){
        $('#register_form_<?php echo $uid; ?>').restForm({
          success: function(result){
            if(result.success)
              window.location = '<?php echo $data->target_url; ?>';
          },
          error: function(){
            <?php echo $data->captcha_reload; ?>
          }
        });
        <?php if($options->autofocus->is_true()): ?>
          $('#register_form_<?php echo $uid; ?>').find('#l_email').focus();
        <?php endif; ?>
      });
    </script>
    
  </section>
  
<?php else: ?>
  
  Je bent al ingelogged.
  
<?php endif; ?>