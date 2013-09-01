<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<p class="settings-description"><?php __($names->component, 'SETTINGS_WEBSITE_INFORMATION_VIEW_DESCRIPTION'); ?></p>

<form id="website_information_form" class="form edit-website-information-form" action="<?php echo url('?rest=cms/settings',1) ?>" method="put">
  
  <div class="language-tabs">
    
    <ul class="tabs"><?php foreach($data->languages as $lang): ?>
      <li><a href="#lang_<?php echo $lang->id; ?>"><?php echo __($lang->title); ?></a></li>
    <?php endforeach; ?></ul>
    
    <?php foreach($data->languages as $lang): ?>
      
      <div class="content" id="lang_<?php echo $lang->id; ?>">
        
        <?php foreach($data->settings as $name => $setting): ?>
          
          <div class="ctrlHolder">
            <label for="l_value_<?php echo $name; ?>_<?php echo $lang->id; ?>"><?php __($names->component, $data->titles->{$name}); ?></label>
            <input type="text" class="big large" id="l_value_<?php echo $name; ?>_<?php echo $lang->id; ?>"
              name="<?php echo $name."[{$lang->id}]"; ?>" value="<?php echo $setting->{'value_'.$lang->id}; ?>" />
          </div>
          
        <?php endforeach; ?>
        
      </div>
      
    <?php endforeach; ?>
    
  </div>
  
  <div class="buttonHolder">
    <input type="submit" value="<?php __('Save'); ?>" class="primaryAction button black">
  </div>
  
</form>

<script type="text/javascript">
$(function(){
  $('#website_information_form').restForm();
  $('.language-tabs').idTabs();
});
</script>
