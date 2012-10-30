<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<h1><?php __($names->component, 'Website settings', 'ucfirst'); ?></h1>

<h2><?php __($names->component, 'Main settings', 'ucfirst'); ?></h2>

<div id="com-cms--settings">
<?php echo $data->setting_list; ?>
</div>

<h2><?php __($names->component, 'IP filters', 'ucfirst'); ?></h2>

<div id="com-cms--ip-adresses">
<?php echo $data->ip_list; ?>
</div>
