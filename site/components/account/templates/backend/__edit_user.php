<?php namespace components\account; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);
$create = $data->id->get('int') < 1;
$uid = tx('Security')->random_string(20);
?>

<form method="post" id="<?php echo $uid; ?>" action="<?php echo url('action=account/edit_user/post'); ?>" class="form edit-user-form">
  
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
    <input class="big large" type="password" id="l_password" name="password" value="" placeholder="wachtwoord verborgen" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_name" accesskey="f"><?php __('First name'); ?></label>
    <input class="big large" type="text" id="l_name" name="name" value="<?php echo $edit_user->name; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_preposition" accesskey="t"><?php __('Preposition'); ?></label>
    <input class="big large" type="text" id="l_preposition" name="preposition" value="<?php echo $edit_user->preposition; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_family_name" accesskey="l"><?php __('Last name'); ?></label>
    <input class="big large" type="text" id="l_family_name" name="family_name" value="<?php echo $edit_user->family_name; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_comments" accesskey="c"><?php __('Comments'); ?></label>
    <textarea class="big large" id="l_comments" name="comments"><?php echo $edit_user->user_info->comments; ?></textarea>
  </div>
  
  <?php
    
    if(false && $create)
    {
      
      ?>
        <div class="ctrlHolder">
          <label for="l_choose_password" accesskey="a"><input class="big large" type="checkbox" id="l_choose_password" name="choose_password" value="1" /> <?php __($names->component, 'Let user choose password'); ?></label>
        </div>
      <?php
      
    }
  
  ?>
  
  <div class="ctrlHolder">
    <label for="l_admin" accesskey="a">
      <input class="big large" type="checkbox" id="l_admin" name="admin"<?php echo ($data->level->get('int') === 2 ? ' checked="checked"' : ''); ?> />
      <?php __('Administrator'); ?>
    </label>
  </div>
  
  <?php
  
    if($create)
    {
      
      ?>
        <div class="ctrlHolder" hidden>
          <label for="l_notify_user" accesskey="n"><input class="big large" type="checkbox" id="l_notify_user" name="notify_user" value="1" /> <?php __($names->component, 'Notify user of update'); ?></label>
        </div>
      <?php
      
    }
  
  ?>
  
  <fieldset class="fieldset-user-groups">
    
    <legend><?php echo __($names->component, 'Member of groups'); ?></legend>
    
    <ul>
      <?php
      
      $usersGroups = $data->groups->map(function($group){
        return $group->id->get('string');
      })->as_array();
      
      tx('Sql')
        ->table('account', 'UserGroups')
        ->order('title')
        ->execute()
        ->each(function($group)use($usersGroups){
          echo '<li><label><input type="checkbox" name="user_group['.$group->id.']" value="1"'.(in_array($group->id->get(), $usersGroups) ? ' CHECKED' : '').' /> '.$group->title.'</label></li>'.n;
        });
      
      ?>
    </ul>
    
  </fieldset>
  
  <div class="buttonHolder">
    <input class="primaryAction button black" type="submit" value="<?php __('Save'); ?>" />
  </div>

</form>
<script type="text/javascript">
$(function(){
  
  var pass_field = $('#<?php echo $uid; ?> #l_password');
  var pass_val = '';
  var notify = $('#<?php echo $uid; ?> #l_notify_user');
  
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
  
});
</script>
