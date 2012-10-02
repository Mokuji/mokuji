<?php

echo $user_profile->image_uploader;

?>
<div id="edit-profile-form">
  <form method="post" action="<?php echo url('?action=account/edit_profile/post', true); ?>">
  
    <input type="hidden" name="id" value="<?php echo tx('Account')->user->id->get('int'); ?>" />
    <input type="hidden" name="redirect_url" value="<?php echo $user_profile->options->redirect_url; ?>" />
  
    <div class="left">
      <fieldset>

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
            <a id="file-browse" class="file-browse" href="#">Upload uw foto</a>
          </div>
        </div>

      </fieldset>
    </div>
    <div class="right">
      <fieldset>
        <label for="l_email"><?php __('Email address'); ?>:</label>
        <input type="text" name="email_address" id="l_email" value="<?php echo tx('Account')->user->email->get('string'); ?>" disabled="disabled" />
      </fieldset>
      <fieldset>
        <?php if($user_profile->need_old_password->is_true()){ ?>
        <label for="l_password_old"><?php __('Old password'); ?>:</label>
        <input type="password" name="password_old" placeholder="<?php __('Old password'); ?>" />
        <?php } ?>
        <label for="l_password1"><?php __('New password'); ?>:</label>
        <input type="password" name="password1" placeholder="<?php __('New password'); ?>" />
        <label for="l_password2"><?php __('Confirm new password'); ?>:</label>
        <input type="password" name="password2" placeholder="<?php __('Confirm new password'); ?>" />
      </fieldset>
      <fieldset>
        <label><?php __('Voornaam'); ?>:</label>
        <input type="text" name="name" placeholder="Voornaam" value="<?php echo $user_profile->user->name; ?>" />
        <label><?php __('Tussenvoegsel'); ?>:</label>
        <input type="text" name="preposition" placeholder="Tussenvoegsel" value="<?php echo $user_profile->user->preposition; ?>" />
        <label><?php __('Achternaam'); ?>:</label>
        <input type="text" name="family_name" placeholder="Achternaam" value="<?php echo $user_profile->user->family_name; ?>" />
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
      <input type="submit" value="Wijzigingen opslaan" />
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
