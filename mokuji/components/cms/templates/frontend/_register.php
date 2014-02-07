<form action="<?php echo url('action=cms/register/post', true); ?>" method="post">

  <div class="ctrlHolder">
    <label><?php __('Email'); ?></label>
    <input type="text" name="email">
  </div>
  <div class="ctrlHolder">
    <label><?php __('Username'); ?></label>
    <input type="text" name="username">
  </div>
  <div class="ctrlHolder">
    <label><?php __('Password'); ?></label>
    <input type="password" name="password">
  </div>

  <input type="submit" value="<?php __($names->component, 'Create user'); ?>">

</form>
