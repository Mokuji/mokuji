<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<form id="edit_cms_settings" class="form edit-cms-settings-form" action="<?php echo url('?rest=cms/settings',1) ?>" method="put">
  
  <div class="ctrlHolder">
    <label><?php __($names->component, 'Key'); ?></label>
    <div class="key-name"><?php echo $data->item->key; ?><input type="hidden" name="key" value="<?php echo $data->item->key; ?>" /></div>
  </div>
  
  <div class="ctrlHolder">
    <label for="l_value_default"><?php __($names->component, 'Default value'); ?></label>
    <input type="text" class="big large" id="l_value_default" name="value_default" value="<?php echo $data->item->value_default; ?>" />
  </div>
  
  <?php tx('Language')->multilanguage(function($lang)use($data){ ?>
    <div class="ctrlHolder">
      <label for="l_value_<?php echo $lang->id; ?>"><?php echo __($lang->title,1).' '.__('value',1); ?></label>
      <input type="text" class="big large" id="l_value_<?php echo $lang->id; ?>" name="value[<?php echo $lang->id; ?>]" value="<?php echo $data->item->{'value_'.$lang->id}; ?>" />
    </div>
  <?php }); ?>
  
  <div class="buttonHolder">
    <input type="submit" value="<?php __('Save'); ?>" class="primaryAction button black">
  </div>
  
</form>

<script type="text/javascript">
$(function(){
  
  $('#edit_cms_settings').restForm({
    success: function(){
      $.ajax('<?php echo url("?section=cms/setting_list"); ?>').done(function(html){
        $('#com-cms--settings').html(html);
      });
    }
  });
  
});
</script>
