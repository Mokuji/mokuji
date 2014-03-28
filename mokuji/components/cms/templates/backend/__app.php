<?php namespace components\cms; if(!defined('MK')) die('No direct access.'); ?>

<div id="app">
  
  <?php echo $data->edit_menu_item; ?>
  <?php echo $data->edit_page; ?>
  
  <div id="menu_app"></div>
  <div id="page_app"></div>
  
</div>

<div id="config_app" style="display:none;">
  <div class="inner clearfix"></div>
</div>

<script type="text/javascript">
  jQuery(function($){
    app.Item.loadItemContents(<?php echo $data->menu_id->otherwise('false'); ?>);
    app.Page.loadPageContents(<?php echo $data->page_id->otherwise('false'); ?>);
    app.MenuItems.collapseItems(0);
    var view = "<?php echo $data->view; ?>";
    if(view.length > 0){
      app.Settings.loadView(view);
      app.Settings.activate();
    }
  });
</script>
