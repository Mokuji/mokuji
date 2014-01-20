<?php namespace components\backup; if(!defined('MK')) die('No direct access.'); ?>

<p class="backup-profiles-description"><?php __($names->component, 'BACKUP_PROFILES_VIEW_DESCRIPTION'); ?></p>

<p><?php echo transf($names->component, 'Backups will be saved in {0}.', $data->backup_folder); ?></p>

<?php if($data->free_space->is_set()){ ?>
  <p><?php echo transf($names->component, 'Disk space left in target folder is {0}GB.', $data->free_space); ?></p>
<?php } ?>

<?php
// echo $data->profiles->as_table(array(
//   __('Name',true) => 'name',
//   __('Title',true) => 'title',
//   __($names->component, 'Table selection',true) => 'table_selection',
//   __($names->component, 'DROP TABLE',true) => function($r){ return $r->table_drop->get() ? __('Yes',true) : __('No',true); },
//   __($names->component, 'Table structure',true) => function($r){ return $r->table_structure->get() ? __('Yes',true) : __('No',true); },
//   __($names->component, 'Table data',true) => function($r){ return $r->table_data->get() ? __('Yes',true) : __('No',true); },
//   __($names->component, 'Rows per insert',true) => 'table_rows_per_insert',
//   __($names->component, 'Output include comments',true) => function($r){ return $r->output_include_comments->get() ? __('Yes',true) : __('No',true); },
//   __('Actions',true) => function($r){
//     return '<a href="#" class="button grey" data-profile="'.$r->name.'">Execute</a>';
//   }
// ));

foreach ($data->profiles as $profile)
{
  
  echo $profile->render_form($fid, '?rest=backup/profiles', array(
    'class' => 'backup-profile clearfix',
    'method' => 'PUT',
    'fieldsets' => array(
      'Caption' => array('name', 'title'),
      'Table selection mode' => array('table_selection'),
      'Table options' => array('table_drop', 'table_structure', 'table_data'),
      'Output options' => array('output_include_comments')
    ),
    'buttons' => array(
      'execute-profile grey icon-cogs',
      'delete-profile red icon-trash'
    )
  ));
  
}

?>

<a class="button grey backup-profile-controls add-profile icon-plus">&nbsp;</a>

<script type="text/javascript">
jQuery(function($){
  
  var hasFeedback = (window.app && app.Feedback);
  
  $('form.backup-profile')
    .restForm()
    
    .on('click', '.execute-profile', function(e){
      
      e.preventDefault();
      var name = $(e.target).closest('form').find('.for_name input').val();
      
      if(hasFeedback) app.Feedback.working('Executing '+name+' backup profile');
      
      $.rest('GET', "<?php echo URL_BASE; ?>rest/backup/execute_profile/"+name)
        .done(function(result){
          if(hasFeedback) app.Feedback.success("Successfully executed backup");
          else alert("Successfully executed backup.\n"+result.path);
        })
        .error(function(xhr, state, message){
          if(hasFeedback) app.Feedback.error(message);
        });
      
    });
  
});
</script>