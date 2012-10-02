<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2);

$form_id = tx('Security')->random_string(20);

?>

<form id="<?php echo $form_id; ?>" method="post" action="<?php echo url("action=cms/save_settings_simple/post"); ?>" class="form-inline-elements">

  <div class="ctrlHolder">
    <label><?php __('Homepage'); ?></label>
    <select name="homepage">
      <option value="">-- <?php __('Select the homepage'); ?> --</option>
      <?php
      $data->pages->each(function($row)use($data){
        echo
          '<option value="pid='.$row->id.'"'.(strpos($data->config->homepage->get(), 'pid='.$row->id) !== false ? ' selected="selected"' : '').'>'.$row->title.'</option>';
      });
      ?>
    </select>
  </div>

  <div class="ctrlHolder">
    <label><?php __('Login page'); ?></label>
    <select name="login_page">
      <option value="">-- <?php __('Select the login page'); ?> --</option>
      <?php
      $data->pages->each(function($row)use($data){
        echo
          '<option value="pid='.$row->id.'"'.(strpos($data->config->login_page->get(), 'pid='.$row->id) !== false ? ' selected="selected"' : '').'>'.$row->title.'</option>';
      });
      ?>
    </select>
  </div>

<!--
  <div class="ctrlHolder">
    <label><?php __('Default theme'); ?></label>
    <input class="big" type="text" name="theme_id" value="<?php echo $data->config->theme_id; ?>" />
  </div>

  <div class="ctrlHolder">
    <label><?php __('Default template'); ?></label>
    <input class="big" type="text" name="template_id" value="<?php echo $data->config->homepage; ?>" />
  </div>
-->

  <?php echo form_buttons(); ?>

</form>

<script type="text/javascript">

$(function(){

  $('#<?php echo $form_id; ?>').on('submit', function(e){
    e.preventDefault();
    $(this).ajaxSubmit(function(data){
      $('#com-cms--settings').html(data);
    });
  });

});

</script>