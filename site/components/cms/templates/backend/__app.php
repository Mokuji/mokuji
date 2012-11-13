<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<div id="app">
  
  <?php echo $data->edit_menu_item; ?>
  <?php echo $data->edit_page; ?>
  
  <div id="menu_app"></div>
  <div id="page_app"></div>
  
  <script type="text/javascript">
    jQuery(function($){
      app.Item.loadItemContents(<?php echo $data->menu_id->otherwise('false'); ?>);
      app.Page.loadPageContents(<?php echo $data->page_id->otherwise('false'); ?>);
    });
  </script>
  
</div>
