<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<script type="text/javascript">
jQuery(function($){
  
  var keepAliveTimeout = 60*1000; //60s
  var keepAlive = function(){
    $.ajax({
      type:'get',
      url:'?rest=cms/keep_alive'
    });
  };
  
  //Please setInterval, keep us alive!
  setInterval(keepAlive, keepAliveTimeout);
  
});
</script>

<?php if(tx('Config')->system()->check('backend')): ?>

<!-- Back-end top-bar. -->
<div id="topbar">
  
  <ul id="topbar_menu">
    
    <!-- Profile menu -->
    <li class="profile dropdown">
      
      <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
        <span title="<?php echo tx('Account')->user->username; ?>">
          <?php echo tx('Account')->user->username; ?>
        </span>
      </a>
      
      <ul class="dropdown-menu" role="menu">
        <li>
          <a tabindex="-1" href="<?php echo url('action=account/logout'); ?>">
            <?php __($names->component, 'Logout', 'ucfirst'); ?>
          </a>
        </li>
      </ul>
      
    </li>
    
    <!-- Back to website. -->
    <li class="website">
      <a title="<?php __($names->component, 'Go back to the website'); ?>" href="<?php echo $admin_toolbar->website_url; ?>">
        <?php __('Website') ?>
      </a>
    </li>
    
    <!-- Location indicator -->
    <li class="advanced active">
      <a href="javascript:void(0);return false" title="<?php __($names->component, 'You are currently in the admin-panel'); ?>">
        <?php __($names->component, 'Control Panel Home') ?>
      </a>
    </li>
    
  </ul>

</div>

<?php else: ?>

<!-- Front-end top-bar. -->
<ul id="topbar_menu">
  
  <?php if(tx('Account')->check_level(2)): ?>
    
  <li class="website<?php if(!$data->check('editable')) echo ' active'; ?>">
    <a title="<?php __($names->component, 'View this page'); ?>" href="<?php echo $admin_toolbar->website_url; ?>"><?php __('Website'); ?></a>
  </li>
  
  <li class="website-edit<?php if($data->check('editable')) echo ' active'; ?>">
    <a  title="<?php __($names->component, 'Edit this page'); ?>" href="<?php echo $admin_toolbar->edit_url; ?>"><?php __('Edit') ?></a>
  </li>
  
  <li class="advanced-edit">
    <a title="<?php __($names->component, 'Manage this page'); ?>" href="<?php echo $admin_toolbar->advanced_url; ?>">
      <?php __($names->component, 'Page Control'); ?>
    </a>
  </li>
  
  <li class="advanced">
    <a title="<?php __($names->component, 'Manage the website'); ?>" href="<?php echo $admin_toolbar->admin_url; ?>">
      <?php __($names->component, 'Control Panel'); ?>
    </a>
  </li>
    
  <?php endif; ?>

</ul>

<?php endif; ?>
