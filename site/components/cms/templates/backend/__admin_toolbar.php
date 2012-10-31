<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<div id="topbar">
  
  <ul id="topbar_menu">
    <li class="logout"><a href="<?php echo url('action=account/logout'); ?>"><?php __($names->component, 'Logout', 'ucfirst'); ?></a></li>
    <li class="website"><a title="<?php __($names->component, 'Go back to the website'); ?>" href="<?php echo $admin_toolbar->website_url; ?>"><?php __('Website') ?></a></li>
<!--
    <li class="website-edit"><a href="<?php echo $admin_toolbar->edit_url; ?>">Editable website</a></li>
    <li class="advanced-edit"><a href="<?php echo $admin_toolbar->edit_url; ?>">Advanced edit</a></li>
-->
    <li class="advanced active"><a href="<?php echo $admin_toolbar->admin_url; ?>"><?php __($names->component, 'Control Panel Home') ?></a></li>
  </ul>

</div>

