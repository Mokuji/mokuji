<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);
$create = $data->id->get('int') < 1;
$uid = tx('Security')->random_string(20);
?>

<form method="<?php echo ($create ? 'post' : 'put') ?>" id="<?php echo $uid; ?>" action="<?php echo url('rest=account/user'); ?>" class="form edit-user-form">
  
  <input type="hidden" name="id" value="<?php echo $edit_user->id ?>" />
  
  <div class="ctrlHolder">
    <label for="l_email" accesskey="e"><?php __('Email address'); ?></label>
    <input class="big large" type="text" id="l_email" name="email" value="<?php echo $edit_user->email; ?>" required />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_username" accesskey="g"><?php __('Username'); ?></label>
    <input class="big large" type="text" id="l_username" name="username" value="<?php echo $edit_user->username; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_password" accesskey="p"><?php __('Password'); ?></label>
    <label><input type="radio" name="password_method" value="claim"<?php if($data->password->is_empty()) echo ' checked="checked"'; ?>> Let user decide</label>
    <label><input type="radio" name="password_method" value="admin"<?php if(!$data->password->is_empty()) echo ' checked="checked"'; ?>> Manually set one</label>
    <input class="big large" type="password" id="l_password" name="password" value="" placeholder="<?php __($names->component, 'Password hidden'); ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_first_name" accesskey="f"><?php __('First name'); ?></label>
    <input class="big large" type="text" id="l_first_name" name="first_name" value="<?php echo $edit_user->first_name; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_last_name" accesskey="l"><?php __('Last name'); ?></label>
    <input class="big large" type="text" id="l_last_name" name="last_name" value="<?php echo $edit_user->last_name; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_comments" accesskey="c"><?php __('Comments'); ?></label>
    <textarea class="big large" id="l_comments" name="comments"><?php echo $edit_user->user_info->comments; ?></textarea>
  </div>
  
  <?php if(false && $create): ?>
    <div class="ctrlHolder">
      <label for="l_choose_password" accesskey="a"><input class="big large" type="checkbox" id="l_choose_password" name="choose_password" value="1" /> <?php __($names->component, 'Let user choose password'); ?></label>
    </div>
  <?php endif; ?>
  
  <div class="ctrlHolder">
    <label for="l_is_active">
      <input class="big large" type="checkbox" id="l_is_active" name="is_active"<?php echo ($data->check('is_active') ? ' checked="checked"' : ''); ?> />
      <?php __('Activated'); ?>
    </label>
    <label for="l_is_banned">
      <input class="big large" type="checkbox" id="l_is_banned" name="is_banned"<?php echo ($data->check('is_banned') ? ' checked="checked"' : ''); ?> />
      <?php __('Banned'); ?>
    </label>
    <label for="l_admin" accesskey="a">
      <input class="big large" type="checkbox" id="l_admin" name="admin"<?php echo ($data->level->get('int') === 2 ? ' checked="checked"' : ''); ?> />
      <?php __('Administrator'); ?>
    </label>
  </div>
  
  <?php if($create): ?>
    <div class="ctrlHolder" hidden>
      <label for="l_notify_user" accesskey="n"><input class="big large" type="checkbox" id="l_notify_user" name="notify_user" value="1" /> <?php __($names->component, 'Notify user of update'); ?></label>
    </div>
  <?php endif; ?>
  
  <?php

  $all_usergroups = tx('Sql')
    ->table('account', 'UserGroups')
    ->order('title')
    ->execute();

  //Show the usergroups, but only if there are any.
  if($all_usergroups->size() > 0)
  {
    ?>

  <fieldset class="fieldset-user-groups">
    
    <legend><?php echo __($names->component, 'Member of groups'); ?></legend>
    
    <ul>
      <?php

      $usersGroups = $data->groups->map(function($group){
        return $group->id->get('string');
      })->as_array();
      
      $all_usergroups->each(function($group)use($usersGroups){
        echo '<li><label><input type="checkbox" name="user_group['.$group->id.']" value="1"'.(in_array($group->id->get(), $usersGroups) ? ' CHECKED' : '').' /> '.$group->title.'</label></li>'.n;
      });
     
      ?>
    </ul>
    
  </fieldset>

    <?php
  }
  ?>
  
  <div class="buttonHolder">
    <input class="primaryAction button black" type="submit" value="<?php __('Save'); ?>" />
  </div>

</form>

<script type="text/javascript">
$(function(){
  
  var pass_field = $('#<?php echo $uid; ?> #l_password');
  var pass_val = '';
  var notify = $('#<?php echo $uid; ?> #l_notify_user');
  
  pass_field.PasswordStrength();
  
  $('#<?php echo $uid; ?> #l_choose_password').on('change', function(){
  
    if($(this).is(':checked')){
      
      notify.data('is_checked', notify.is(':checked'));
      notify.prop('checked', true);
      notify.prop('disabled', true);
      
      pass_field.prop('disabled', true);
      pass_val = pass_field.val();
      pass_field.val('');
      pass_field.attr('placeholder', "<?php __($names->component, 'User must set this', 'l'); ?>");
      
    }
    
    else{
      
      if(notify.data('is_checked') == true){
        notify.prop('checked', true);
      }else{
        notify.prop('checked', false);
      }
      notify.prop('disabled', false);
      
      pass_field.prop('disabled', false);
      pass_field.val(pass_val);
      pass_field.attr('placeholder', "<?php __($names->component, 'Password hidden', 'l'); ?>");
      
    }
    
  }).trigger('change');
  
  $('#<?php echo $uid; ?>').restForm({
    success: function(data){
      $('#tab-users').html(data);
      $('#tabber-users a').trigger('click');
    },
    failure: function(xhr, state, message){
      console.log(arguments);
      alert('error');
    }
  });
  
});
</script>
