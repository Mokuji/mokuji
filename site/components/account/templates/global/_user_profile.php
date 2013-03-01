<?php

echo $user_profile->image_uploader;

?>
<div id="edit-profile-form">
  <form method="post" action="<?php echo url('?action=account/edit_profile/post', true); ?>">
  
    <input type="hidden" name="id" value="<?php echo tx('Account')->user->id->get('int'); ?>" />
    <input type="hidden" name="redirect_url" value="<?php echo $user_profile->options->redirect_url; ?>" />
  
    <div class="left">
      <fieldset>
        
        <?php if($data->has_media->is_true()): ?>
          <div class="avatar_holder">
            <input type="hidden" id="avatar_image_id" name="avatar_image_id" value="<?php $user_profile->user->avatar_image_id->get('int'); ?>" />
            <?php if($user_profile->user->avatar_image_id->get('int') > 0){ ?>
            <img src="<?php echo url('section=media/image&id='.$user_profile->user->avatar_image_id->get('int').'&resize=0/97', true); ?>" />
            <?php } ?>
          </div>

          <div id="file-container" class="fileupload-container">
            <div id="file-drop" class="file-drop">
              <div id="file-filelist" class="file-filelist"></div>
              <div id="file-drop" class="drag-here"></div>
            </div>
            <div class="buttonHolder">
              <a id="file-browse" class="file-browse" href="#"><?php __($names->component, 'Upload your picture'); ?></a>
            </div>
          </div>
        
        <?php endif; ?>

      </fieldset>
    </div>
    <div class="right">
      <fieldset>
        <label for="l_email"><?php __('Email address'); ?>:</label>
        <input type="text" name="email_address" id="l_email" value="<?php echo tx('Account')->user->email->get('string'); ?>" disabled="disabled" />
      </fieldset>
      <fieldset>
        <?php if($user_profile->need_old_password->is_true()){ ?>
        <label for="l_password_old"><?php __($names->component, 'Old password'); ?>:</label>
        <input type="password" name="password_old" placeholder="<?php __($names->component, 'Old password'); ?>" />
        <?php } ?>
        <label for="l_password1"><?php __($names->component, 'New password'); ?>:</label>
        <input type="password" name="password1" placeholder="<?php __($names->component, 'New password'); ?>" />
        <label for="l_password2"><?php __($names->component, 'Confirm new password'); ?>:</label>
        <input type="password" name="password2" placeholder="<?php __($names->component, 'Confirm new password'); ?>" />
      </fieldset>
      <fieldset>
        <label><?php __('First name'); ?>:</label>
        <input type="text" name="name" placeholder="<?php __('First name'); ?>" value="<?php echo $user_profile->user->name; ?>" />
        <label><?php __('Preposition'); ?>:</label>
        <input type="text" name="preposition" placeholder="<?php __('Preposition'); ?>" value="<?php echo $user_profile->user->preposition; ?>" />
        <label><?php __('Last name'); ?>:</label>
        <input type="text" name="family_name" placeholder="<?php __('Last name'); ?>" value="<?php echo $user_profile->user->family_name; ?>" />
      </fieldset>
      <!--
      <fieldset>
        <input type="text" name="street_name" value="Straatnaam" class="form_left width_65" value="<?php echo $user_profile->street_name; ?>" />
        <input type="text" name="house_number" value="Huisnummer" class="form_right width_35" />
        <input type="text" name="postcode" value="Postcode" class="form_left width_25" />
        <input type="text" name="city" value="Woonplaats" class="form_right width_75" />
      </fieldset>
      <fieldset>
        <input type="text" name="phone_land" value="Telefoon vast" />
        <input type="text" name="phone_mobile" value="Telefoon mobiel" />
      </fieldset>
      -->
      <input type="submit" value="<?php __('Save'); ?>" />
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
    //Show thumbnail of uploaded icon
    $("#edit-profile-form .avatar_holder").html("<img src=\"<?php echo url('section=media/image'); ?>&id="+file_id+"&resize=0/97\" height=\"97\" />");
  })
  .fail(function(){
    console.log("Failed to save avatar.");
  });
}

</script>
