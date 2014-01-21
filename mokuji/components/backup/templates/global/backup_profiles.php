<?php namespace components\backup; if(!defined('MK')) die('No direct access.'); ?>

<p class="backup-profiles-description"><?php __($names->component, 'BACKUP_PROFILES_VIEW_DESCRIPTION'); ?></p>

<p><?php echo transf($names->component, 'Backups will be saved in {0}.', $data->backup_folder); ?></p>

<?php if($data->free_space->is_set()){ ?>
  <p><?php echo transf($names->component, 'Disk space left in target folder is {0}GB.', $data->free_space); ?></p>
<?php } ?>

<div class="backup-profiles">

<?php

$form_options = array(
  'class' => 'backup-profile clearfix',
  // 'method' => 'PUT',
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
);

foreach ($data->profiles as $profile)
  $profile->render_form($fid, '?rest=backup/profiles', array_merge(array('method' => 'PUT'), $form_options));

?>

</div>

<div class="new-profile-form">
  <?php $data->model->render_form($fid, '?rest=backup/profiles', array_merge(array('method' => 'POST'), $form_options)); ?>
</div>

<a class="button grey backup-profile-controls add-profile icon-plus">&nbsp;</a>

<script type="text/javascript">
jQuery(function($){
  
  var hasFeedback = (window.app && app.Feedback);
  
  var restFormOpts = {
    success:function(result, form){
      $(form)
        .attr('method', 'PUT')
        .find('input[name="name"]').attr('disabled', 'disabled');
    }
  };
  
  $('.backup-profiles')
    
    //Execute functionality.
    .on('click', '.backup-profile .execute-profile.grey', function(e){
      
      e.preventDefault();
      
      //Disable the button, for visual feedback.
      var $target = $(e.target);
      $target.removeClass('grey');
      
      //Which profile.
      var name = $target.closest('form').find('.for_name input').val();
      
      //Notify user.
      if(hasFeedback) app.Feedback.working('Executing '+name+' backup profile');
      
      //Execute the profile.
      $.rest('GET', "<?php echo URL_BASE; ?>rest/backup/execute_profile/"+name)
        
        //Success handler.
        .done(function(result){
          $target.addClass('grey');
          if(hasFeedback) app.Feedback.success("Successfully executed backup");
          else alert("Successfully executed backup.\n"+result.path);
        })
        
        //Error handler.
        .error(function(xhr, state, message){
          $target.addClass('grey');
          if(hasFeedback) app.Feedback.error(message);
          else alert(message);
        });
      
    })
    
    //Delete functionality.
    .on('click', '.backup-profile .delete-profile',function(e){
      e.preventDefault();
      
      if(confirm("<?php __($names->component, 'Are you sure?'); ?>")){
        
        var $form = $(this).closest('.backup-profile');
        var $name = $form.find('input[name="name"]');
        
        //Notify user.
        if(hasFeedback) app.Feedback.working('Deleting '+name+' backup profile');
        
        //Including REST call.
        if($name.is(':disabled')){
          
          $.rest('DELETE', $form.attr('action'), {'name': $name.val()})
            
            //Success handler.
            .done(function(){
              $form.slideUp(function(){ $(this).remove(); });
              if(hasFeedback) app.Feedback.success("Successfully deleted profile");
              else alert("Successfully deleted profile.");
            })
            
            //Error handler.
            .error(function(xhr, state, message){
              if(hasFeedback) app.Feedback.error(message);
              else alert(message);
            });
          
        }
        
        //Without REST call.
        else{
          $form.slideUp(function(){ $(this).remove(); });
          if(hasFeedback) app.Feedback.success("Successfully deleted profile");
          else alert("Successfully deleted profile.");
        }
        
      }
      
    })
    
    //Save functionality.
    .find('form.backup-profile').restForm(restFormOpts)
    
    //Disable name field.
    .find('input[name="name"]').attr('disabled', 'disabled');
  
  //Add profile functionality.
  $('.add-profile').on('click', function(e){
    e.preventDefault();
    
    var $form = $('.new-profile-form').find('form.backup-profile').clone();
    
    $form
      .restForm(restFormOpts)
      .find('input:eq(0)').focus();
    
    $('.backup-profiles').append($form);
    
  });
  
});
</script>