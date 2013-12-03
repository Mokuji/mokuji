<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Transfer configuration</h2>
  </div>
  <div class="body clearfix">
    <p>Next we will transfer the configuration files. Please verify the details below.</p>
    <p class="notes">
      Note 1: Make sure that the MySQL user you provide is granted full access to the database.<br>
      Note 2: While passwords for MySQL users are optional, Mokuji requires you to set a password for security reasons.
    </p>
    
    <form method="post" action="#" data-action="<?php echo url('/install/?rest=update/config_upgrade', true); ?>" data-test-action="<?php echo url('/install/?rest=update/db_test', true); ?>" class="form db-install-form">
      
      <br><h3>E-mail settings</h3>
      
      <div class="ctrlHolder">
        <label for="l_email_webmaster_name">Webmaster name</label>
        <input class="small" type="text" id="l_email_webmaster_name" name="email_webmaster_name" value="<?php echo defined('EMAIL_NAME_WEBMASTER') ? EMAIL_NAME_WEBMASTER : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_email_webmaster">Webmaster email</label>
        <input class="small" type="text" id="l_email_webmaster" name="email_webmaster" value="<?php echo defined('EMAIL_ADDRESS_WEBMASTER') ? EMAIL_ADDRESS_WEBMASTER : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_email_automated_name">Automated messages name</label>
        <input class="small" type="text" id="l_email_automated_name" name="email_automated_name" value="<?php echo defined('EMAIL_NAME_AUTOMATED_MESSAGES') ? EMAIL_NAME_AUTOMATED_MESSAGES : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_email_automated">Automated messages email</label>
        <input class="small" type="text" id="l_email_automated" name="email_automated" value="<?php echo defined('EMAIL_ADDRESS_AUTOMATED_MESSAGES') ? EMAIL_ADDRESS_AUTOMATED_MESSAGES : ''; ?>" required />
      </div>
      
      <br><h3>Database settings</h3>
      
      <div class="ctrlHolder">
        <label for="l_host" accesskey="h">Database host</label>
        <input class="small" type="text" id="l_host" name="host" value="<?php echo defined('DB_HOST') ? DB_HOST : 'localhost'; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_username" accesskey="u">Username</label>
        <input class="small" type="text" id="l_username" name="username" value="<?php echo defined('DB_USER') ? DB_USER : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_password" accesskey="p">Password</label>
        <input class="small" type="password" id="l_password" name="password" value="<?php echo defined('DB_PASS') ? DB_PASS : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_name" accesskey="n">Database name</label>
        <input class="small" type="text" id="l_name" name="name" value="<?php echo defined('DB_NAME') ? DB_NAME : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_prefix" accesskey="p">Table prefix</label>
        <input class="small" type="text" id="l_prefix" name="prefix" value="<?php echo defined('DB_PREFIX') ? DB_PREFIX : 'mk__'; ?>" required />
      </div>
      
      <p class="actions">
        <a class="button black apply-db" href="#">Save settings</a>
        <a class="button grey test-db" href="#">Test settings</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel upgrade</a>
      </p>
      
      <p id="install-db-message"></p>
      
    </form>
  </div>
  
</div>
