<?php

echo $user_profile->image_uploader;

?>
<div id="edit-profile-form">

  <h1><?php __('account', 'Edit profile'); ?></h1>

  <form method="post" action="<?php echo url('?action=account/edit_profile/post', true); ?>">
  
    <input type="hidden" name="id" value="<?php echo tx('Account')->user->id->get('int'); ?>" />
    <input type="hidden" name="redirect_url" value="<?php echo $user_profile->options->redirect_url; ?>" />
  
    <div class="left">
      <fieldset>
        
        <?php if($data->has_media->is_true()): ?>
          <div class="avatar_holder">
            <input type="hidden" id="avatar_image_id" name="avatar_image_id" value="<?php $user_profile->user->avatar_image_id->get('int'); ?>" />
            <?php if($data->user->user_info->avatar != false){ ?>
            <img src="<?php echo $data->user->user_info->avatar->generate_url(array('resize_width' => 146)); ?>" />
            <?php } ?>
          </div>

          <div id="file-container" class="fileupload-container">
            <div id="file-drop" class="file-drop">
              <div id="file-filelist" class="file-filelist"></div>
              <div id="file-drop" class="drag-here"></div>
            </div>
            <div class="buttonHolder">
              <a id="file-browse" class="file-browse" href="#"><?php __($names->component, 'Upload your avatar'); ?></a>
            </div>
          </div>
        
        <?php endif; ?>

      </fieldset>
    </div>
    <div class="right">
      <fieldset>
        <div class="ctrlHolder">
          <label for="l_email"><?php __('Email address'); ?>:</label>
          <input type="text" name="email_address" id="l_email" value="<?php echo tx('Account')->user->email->get('string'); ?>" disabled="disabled" />
        </div>
      </fieldset>
      <fieldset>
        <div class="ctrlHolder">
          <label for="l_username"><?php __('Username'); ?>:</label>
          <input type="text" name="username" id="l_username" value="<?php echo $user_profile->user->username; ?>" />
        </div>
      </fieldset>
      <fieldset>
        <?php if($user_profile->need_old_password->is_true()){ ?>
        <div class="ctrlHolder">
          <label for="l_password_old"><?php __($names->component, 'Old password'); ?>:</label>
          <input type="password" name="password_old" placeholder="<?php __($names->component, 'Old password'); ?>" />
        </div>
        <?php } ?>
        <div class="ctrlHolder">
          <label for="l_password1"><?php __($names->component, 'New password'); ?>:</label>
          <input type="password" name="password1" placeholder="<?php __($names->component, 'New password'); ?>" />
        </div>
        <div class="ctrlHolder">
          <label for="l_password2"><?php __($names->component, 'Confirm new password'); ?>:</label>
          <input type="password" name="password2" placeholder="<?php __($names->component, 'Confirm new password'); ?>" />
        </div>
      </fieldset>
      <fieldset>
        <div class="ctrlHolder">
          <label><?php __('First name'); ?>:</label>
          <input type="text" name="name" placeholder="<?php __('First name'); ?>" value="<?php echo $user_profile->user->name; ?>" />
        </div>
        <div class="ctrlHolder">
          <label><?php __('Preposition'); ?>:</label>
          <input type="text" name="preposition" placeholder="<?php __('Preposition'); ?>" value="<?php echo $user_profile->user->preposition; ?>" />
        </div>
        <div class="ctrlHolder">
          <label><?php __('Last name'); ?>:</label>
          <input type="text" name="family_name" placeholder="<?php __('Last name'); ?>" value="<?php echo $user_profile->user->family_name; ?>" />
        </div>
      </fieldset>

      <div class="buttonHolder">
        <input type="submit" value="<?php __('Save'); ?>" />
      </div>

      <div class="clear"></div>
      
    </div>
    <div class="clear"></div>
  </form>
</div>

<script type="text/javascript">

window.plupload_avatar_image_id_report = function(up, ids, file_id)
{
  
  $("#avatar_image_id").val(file_id);
  
  $.ajax({
    url: '<?php echo url('action=account/save_avatar/post'); ?>',
    type: 'POST',
    data: {
      user_id: <?php echo tx('Account')->user->id->get('int'); ?>,
      avatar_image_id: file_id
    }
  })
  .done(function(data){

    $.rest('GET', '?rest=media/generate_url/'+file_id, {filters:{resize_width:146}})
      .done(function(result){
         $("#edit-profile-form .avatar_holder").html('<img src="'+result.url+'" width="146" />');
      });

  })
  .fail(function(){
    console.log("Failed to save avatar.");
  });
}

</script>
