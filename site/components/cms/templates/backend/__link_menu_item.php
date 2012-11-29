<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<!--
A list of all menu items linked to current page.<br />
An option to link another menu item.<br />
-->

<div id="edit-menu-item">

  <form id="form-menu-item" method="post" action="<?php echo url('action=cms/link_page/post'); ?>" class="form-inline-elements">
    
    <input type="hidden" name="redirect" value="true" />
    <input type="hidden" name="page_id" value="<?php echo tx('Data')->get->pid; ?>" />

    <div class="title-bar page-title">
      <h2><span class="title"></span> <span style="font-weight:normal;"><?php __($names->component, 'Link a menu item'); ?></span></h2>
      <div class="clear"></div>
    </div>

    <div class="body">
      <?php
      if($data->menu_items->size() >= 1){
        echo $data->menu_items->as_options('menu_item_id', 'title', 'id', array('id'=>'menu_item_link', 'placeholder_text' => __($names->component, 'Link a menu item to this page')));
      }else{
        echo 'No unlinked menu items available.';
      }
      ?>
    </div>

  </form>
  
</div>

<script type="text/javascript">

$(function(){
  $('#menu_item_link').on('change', function(e){
    e.preventDefault();
    $(e.target).closest('form').ajaxSubmit(function(data){
      $('#app').replaceWith(data);
    });
  });
});

</script>
