<form action="<?php echo url('action=cms/register/post', true); ?>" method="post">

  <div>
    <?php __('Email'); ?> <input type="text" name="email">
  </div>
  <div>
    <?php __('Username'); ?> <input type="text" name="username">
  </div>
  <div>
    <?php __('Password'); ?> <input type="password" name="password">
  </div>

  <input type="submit" value="<?php __($names->component, 'Create user'); ?>">

</form>
