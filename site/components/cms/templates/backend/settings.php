<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<h1><?php echo ___('Website', 'ucfirst').' '.___('SETTINGS', 'l'); ?></h1>

<h2>Main settings</h2>

<div id="com-cms--settings">
<?php echo $data->setting_list; ?>
</div>

<h2>IP-filters</h2>

<div id="com-cms--ip-adresses">
<?php echo $data->ip_list; ?>
</div>