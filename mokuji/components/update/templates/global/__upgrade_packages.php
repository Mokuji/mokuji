<?php namespace components\update; if(!defined('TX')) die('No direct access.'); ?>

<div id="install_step_app">
  
  <div class="title-bar clearfix">
    <h2>Upgrade packages</h2>
  </div>
  <div class="body clearfix">
    <p>
      Finally we will check for package upgrades.
      This will make sure the database structure is up-to-date and matches the requirements of the currently installed packages.
    </p>
    <form class="form upgrade-packages-form" data-upgrade-action="<?php echo url('/install/?rest=update/package_upgrade', true); ?>">
      <p class="actions">
        <a class="button black upgrade-packages" href="#">Execute</a>
        <a class="button grey cancel" href="<?php echo url('', true); ?>">Cancel upgrade</a>
      </p>
      <p id="upgrade-packages-message"></p>
    </form>
  </div>
  
</div>
