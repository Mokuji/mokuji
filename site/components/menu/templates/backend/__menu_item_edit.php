<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php ($menu_item_edit->item->id->get() > 0 ? __('Edit menu item').': '.$menu_item_edit->item->title : __('New menu item')); ?></h2>

<form id="gallery-category-form" method="post" action="<?php echo url('action=gallery/save_category/post'); ?>" class="form">

  <input type="hidden" name="id" value="<?php echo $menu_item_edit->item->id ?>" />

  <div class="ctrlHolder">
    <label for="l_title" accesskey="t"><?php __('Title'); ?></label>
    <input autofocus class="big large" type="text" id="l_title" name="title" value="<?php echo $menu_item_edit->item->title; ?>" />
  </div>
  
  <div class="ctrlHolder">
    <label for="l_description" accesskey="d"><?php __('Description'); ?></label>
    <textarea class="big large" id="l_description" name="description"><?php echo $menu_item_edit->item->description; ?></textarea>
  </div>
  
  <div class="buttonHolder">
    <input class="primaryAction button black" type="submit" value="Opslaan" />
  </div>
  
</form>

<script type="text/javascript">

  $(function(){

    // $('#gallery-category-form').submit(function(e){
      
      // e.preventDefault();
      
      // $(this).ajaxSubmit();

      // $.ajax({
        // url: '<?php url('view=gallery/gallery_admin&section=cms/config_app', true); ?>'
      // }).done(function(data){
        // $("#page-main-right").html(data);
      // });
    // });
    
  });

</script>

