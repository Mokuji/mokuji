<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<?php if(tx('Account')->check_level(2)): ?>
  <ul id="topbar_menu">
    <li class="website active"><a href="<?php echo $admin_toolbar->website_url; ?>"><?php __('Website'); ?></a></li>
    <!--
    <li><a href="<?php echo $admin_toolbar->edit_url; ?>">Edit</a></li>
    -->
    <li class="advanced-edit"><a title="<?php __($names->component, 'Edit the current webpage'); ?>" href="<?php echo $admin_toolbar->advanced_url; ?>"><?php __('Advanced editing'); ?></a></li>
    <li class="advanced"><a title="<?php __($names->component, 'Manage the website'); ?>" href="<?php echo $admin_toolbar->admin_url; ?>"><?php __('Control Panel'); ?></a></li>
  </ul>
<?php endif; ?>
