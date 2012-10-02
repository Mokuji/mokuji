<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<?php if(tx('Account')->check_level(2)): ?>
  <ul id="topbar_menu">
    <li class="website active"><a href="<?php echo $admin_toolbar->website_url; ?>">Website</a></li>
    <!--
    <li><a href="<?php echo $admin_toolbar->edit_url; ?>">Edit</a></li>
    -->
    <li class="advanced-edit"><a title="Bewerk de huidige webpagina" href="<?php echo $admin_toolbar->advanced_url; ?>">Advanced Edit</a></li>
    <li class="advanced"><a title="Beheer de website" href="<?php echo $admin_toolbar->admin_url; ?>">Control Panel</a></li>
  </ul>
<?php endif; ?>