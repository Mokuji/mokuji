<?php namespace components\account; if(!defined('TX')) die('No direct access.');?>
<div class="please-claim-account-dialogue">
  
  <p class="explanation"><?php __($names->component, 'PLEASE_CLAIM_ACCOUNT_P1'); ?></p>
  
  <form id="claim-account" class="form claim-account-form" method="PUT" action="<?php echo url('?rest=account/password'); ?>">
    
    <?php if(!$data->username->is_empty()){ ?>
      
      <div class="ctrlHolder">
        <label><?php __('Username'); ?></label>
        <span><?php echo $data->username; ?></span>
      </div>
      
    <?php } ?>
    
    <div class="ctrlHolder">
      <label><?php __('E-mail address'); ?></label>
      <span><?php echo $data->email; ?></span>
    </div>
    
    <div class="ctrlHolder">
      <label for="l_password" accesskey="p"><?php __('Password'); ?></label>
      <input class="big large" type="password" id="l_password" name="password" value="" placeholder="<?php __('New password'); ?>" />
    </div>
    
    <div class="ctrlHolder">
      <label for="l_password_check"><?php __('Confirm password'); ?></label>
      <input class="big large" type="password" id="l_password_check" name="password_check" value="" placeholder="<?php __('Confirm password'); ?>" />
    </div>
    
    <div class="buttonHolder">
      <input class="primaryAction button black" type="submit" value="<?php __('Save'); ?>" />
    </div>
    
  </form>
  
  <p class="explanation succeeded" style="display:none;"><?php __($names->component, 'CLAIMING_ACCOUNT_SUCCEEDED'); ?></p>
  
</div>

<script type="text/javascript">
jQuery(function($){
  
  $('#claim-account').restForm({
    success:function(data){
      $('#claim-account').hide();
      $('.please-claim-account-dialogue .succeeded').show();
      $.after('3s').done(function(){
        window.location = '<?php echo URL_BASE; ?>';
      });
    }
  })
  
});
</script>
