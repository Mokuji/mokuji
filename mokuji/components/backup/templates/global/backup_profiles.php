<?php namespace components\backup; if(!defined('MK')) die('No direct access.'); ?>

<p class="backup-profiles-description"><?php __($names->component, 'BACKUP_PROFILES_VIEW_DESCRIPTION'); ?></p>

<p><?php echo transf($names->component, 'Backups will be saved in {0}.', $data->backup_folder); ?></p>

<?php
echo $data->profiles->as_table(array(
  __('Name',true) => 'name',
  __('Title',true) => 'title',
  __($names->component, 'Table selection',true).' [ALL|PREFIXED]' => 'table_selection',
  __($names->component, 'DROP TABLE',true) => function($r){ return $r->table_drop->get() ? __('Yes',true) : __('No',true); },
  __($names->component, 'Table structure',true) => function($r){ return $r->table_structure->get() ? __('Yes',true) : __('No',true); },
  __($names->component, 'Table data',true) => function($r){ return $r->table_data->get() ? __('Yes',true) : __('No',true); },
  __($names->component, 'Rows per insert',true) => 'table_rows_per_insert',
  __($names->component, 'Output include comments',true) => function($r){ return $r->output_include_comments->get() ? __('Yes',true) : __('No',true); },
  __('Actions',true) => function($r){
    return '<a href="#" class="button grey" data-profile="'.$r->name.'">Execute</a>';
  }
));
?>