<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Create admin user</h2>
  </div>
  <div class="body clearfix">
    <p>Finally we create the first administrator account.</p>
    
    <form method="post" action="#" data-action="<?php echo url('/install/?rest=update/admin_installation', true); ?>" class="form admin-create-form">
      
      <div class="ctrlHolder">
        <label for="l_email" accesskey="e">Email address</label>
        <input class="big large" type="text" id="l_email" name="email" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_username" accesskey="u">Username</label>
        <input class="big large" type="text" id="l_username" name="username" />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_password" accesskey="p">Password</label>
        <input class="big large js-add-strength-meter" type="password" id="l_password" name="password" required />
      </div>
      
      <p class="actions">
        <a class="button black create-admin" href="#">Create account</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel installation</a>
      </p>
      
      <p id="create-admin-message"></p>
      
    </form>
  </div>
  
</div>
