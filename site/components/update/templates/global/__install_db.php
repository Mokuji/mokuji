<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Database configuration</h2>
  </div>
  <div class="body clearfix">
    <p>Next we will configure the MySQL database. Please enter the details below.</p>
    <p class="notes">
      Note 1: Make sure that the MySQL user you provide is granted full access to the database.<br>
      Note 2: While passwords for MySQL users are optional, Mokuji requires you to set a password for security reasons.
    </p>
    
    <form method="post" action="#" data-action="<?php echo url('?rest=update/db_installation', true); ?>" data-test-action="<?php echo url('?rest=update/db_test', true); ?>" class="form db-install-form">
      
      <div class="ctrlHolder">
        <label for="l_host" accesskey="h">Database host</label>
        <input class="big large" type="text" id="l_host" name="host" value="<?php echo defined('DB_HOST') ? DB_HOST : 'localhost'; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_username" accesskey="u">Username</label>
        <input class="big large" type="text" id="l_username" name="username" value="<?php echo defined('DB_USER') ? DB_USER : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_password" accesskey="p">Password</label>
        <input class="big large" type="password" id="l_password" name="password" value="<?php echo defined('DB_PASS') ? DB_PASS : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_name" accesskey="n">Database name</label>
        <input class="big large" type="text" id="l_name" name="name" value="<?php echo defined('DB_NAME') ? DB_NAME : ''; ?>" required />
      </div>
      
      <div class="ctrlHolder">
        <label for="l_prefix" accesskey="p">Table prefix</label>
        <input class="big large" type="text" id="l_prefix" name="prefix" value="<?php echo defined('DB_PREFIX') ? DB_PREFIX : 'mk__'; ?>" required />
      </div>
      
      <p class="actions">
        <a class="button black apply-db" href="#">Apply settings</a>
        <a class="button grey test-db" href="#">Test settings</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel installation</a>
      </p>
      
      <p id="install-db-message"></p>
      
    </form>
  </div>
  
</div>
