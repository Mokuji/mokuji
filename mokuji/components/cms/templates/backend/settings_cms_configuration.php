<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<p class="settings-description"><?php __($names->component, 'SETTINGS_CMS_CONFIGURATION_VIEW_DESCRIPTION'); ?></p>

<form id="cms_configuration_form" class="form edit-cms-configuration-form" action="<?php echo url('?rest=cms/settings',1) ?>" method="put">
  
  <?php foreach($data->settings as $name => $setting): ?>
    
    <div class="ctrlHolder">
      <label for="l_value_<?php echo $name; ?>"><?php __($names->component, $data->titles->{$name}); ?></label>
      <?php if($name == 'tx_editor_toolbar') { ?> 
        <textarea class="big large" id="l_value_<?php echo $name; ?>"
          name="<?php echo $name."[default]"; ?>"><?php echo $setting->value_default; ?></textarea>
      <?php } else { ?>
        <input type="text" class="big large" id="l_value_<?php echo $name; ?>"
          name="<?php echo $name."[default]"; ?>" value="<?php echo $setting->value_default; ?>" />
      <?php } ?>
    </div>
    
  <?php endforeach; ?>
  
  <div class="buttonHolder">
    <input type="submit" value="<?php __('Save'); ?>" class="primaryAction button black">
  </div>
  
</form>

<script type="text/javascript">
$(function(){
  $('#cms_configuration_form').restForm();
  $('.language-tabs').idTabs();
});
</script>
