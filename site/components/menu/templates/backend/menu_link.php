<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<form id="menu_linker" method="post" action="<?php echo url('action=cms/save_menu_link/post', true); ?>" class="form-inline-elements">
  <div class="ctrlHolder">
    <p><label><?php __($names->component, 'Target menu item'); ?></label></p>
    <?php echo $data->menu_items->as_options('menu_item_id', 'title', 'id', array('default' => $data->link->menu_item_id)); ?>
  </div>
  <div class="ctrlHolder">
    <fieldset class="fieldset-action">
      <legend><?php __($names->component, 'Link action'); ?></legend>
      <ul>
        <li><label><input type="radio"<?php $data->link->link_action->eq(0, function(){ echo ' checked="checked"'; }); ?> value="0" name="link_action"> <?php __($names->component, 'Redirect'); ?></label></li>
        <li><label><input type="radio"<?php $data->link->link_action->eq(1, function(){ echo ' checked="checked"'; }); ?> value="1" name="link_action"> <?php __($names->component, 'Copy content'); ?></label></li>
      </ul>
    </fieldset>
  </div>
</form>

<script type="text/javascript">
  
  app.Page.subscribe('save', function(e, page_id){
    $('#menu_linker').ajaxSubmit({
      data: {page_id:page_id}
    });
  });
  
</script>
