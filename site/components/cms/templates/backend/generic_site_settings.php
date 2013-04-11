<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'Testing'); ?></h2>

<form id="generic_settings_form" class="form edit-generic-settings-form" action="<?php echo url('?rest=cms/settings',1) ?>" method="put">
  
  <?php foreach($data as $name => $setting): ?>
    
    <div class="ctrlHolder">
      <label for="l_value_<?php echo $name; ?>"><?php __($names->component, $name); ?></label>
      <input type="text" class="big large" id="l_value_<?php echo $name; ?>"
        name="value_<?php echo $name; ?>" value="<?php echo $setting; ?>" />
    </div>
    
  <?php endforeach; ?>
  
  <div class="buttonHolder">
    <input type="submit" value="<?php __('Save'); ?>" class="primaryAction button black">
  </div>
  
</form>

<script type="text/javascript">
$(function(){
  
  $('#generic_settings_form').restForm({
    success: function(){
      $.ajax('<?php echo url("?section=cms/setting_list"); ?>').done(function(html){
        $('#com-cms--settings').html(html);
      });
    }
  });
  
});
</script>
