<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<?php if(tx('Config')->system()->check('backend')){/*BACKEND*/ ?>

<div id="topbar">
  
  <ul id="topbar_menu">
    <li class="profile dropdown">
      <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><span title="<?php echo tx('Account')->user->username; ?>"><?php echo tx('Account')->user->username; ?></span></a>
      <ul class="dropdown-menu" role="menu">
        <li><a tabindex="-1" href="<?php echo url('action=account/logout'); ?>"><?php __($names->component, 'Logout', 'ucfirst'); ?></a></li>
      </ul>
    </li>
    <li class="website"><a title="<?php __($names->component, 'Go back to the website'); ?>" href="<?php echo $admin_toolbar->website_url; ?>"><?php __('Website') ?></a></li>
<!--
    <li class="website-edit"><a href="<?php echo $admin_toolbar->edit_url; ?>">Editable website</a></li>
    <li class="advanced-edit"><a href="<?php echo $admin_toolbar->edit_url; ?>">Advanced edit</a></li>
-->
    <li class="advanced active"><a href="<?php echo $admin_toolbar->admin_url; ?>" title="<?php __('You are now in the admin panel'); ?>"><?php __($names->component, 'Control Panel Home') ?></a></li>
  </ul>

</div>

<?php }else{/*FRONTEND*/ ?>

<ul id="topbar_menu">
  
  <?php if(tx('Account')->check_level(1)): ?>
    <li class="logout"><a href="<?php echo url('action=account/logout'); ?>"><?php __($names->component, 'Logout', 'ucfirst'); ?></a></li>
  <?php endif; ?>

  <?php if(tx('Account')->check_level(2)): ?>
    <li class="website<?php if(!EDITABLE) echo ' active'; ?>"><a href="<?php echo $admin_toolbar->website_url; ?>"><?php __('Website'); ?></a></li>
    <li class="website-edit<?php if(EDITABLE) echo ' active'; ?>"><a href="<?php echo $admin_toolbar->edit_url; ?>">Edit</a></li>
    <li class="advanced-edit"><a title="<?php __($names->component, 'Edit the current webpage'); ?>" href="<?php echo $admin_toolbar->advanced_url; ?>"><?php __('Advanced editing'); ?></a></li>
    <li class="advanced"><a title="<?php __($names->component, 'Manage the website'); ?>" href="<?php echo $admin_toolbar->admin_url; ?>"><?php __('Control Panel'); ?></a></li>
  <?php endif; ?>

</ul>

<?php } ?>
