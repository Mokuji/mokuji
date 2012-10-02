<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<div id="topbar">
  
  <ul id="topbar_menu">
    <li class="logout"><a href="<?php echo url('action=cms/logout'); ?>">Logout</a></li>
    <li class="website"><a title="Ga terug naar de website" href="<?php echo $admin_toolbar->website_url; ?>">Website</a></li>
<!--
    <li class="website-edit"><a href="<?php echo $admin_toolbar->edit_url; ?>">Editable website</a></li>
    <li class="advanced-edit"><a href="<?php echo $admin_toolbar->edit_url; ?>">Advanced edit</a></li>
-->
    <li class="advanced active"><a href="<?php echo $admin_toolbar->admin_url; ?>">Control Panel Home</a></li>
  </ul>

</div>

