<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<div id="new-page-wrap">

  <h1><?php __('Add a page'); ?></h1>

  <ul class="pagetypes-list">
    <?php
    
    $new_page->page_types->each(function($page_type){
      echo
        '  <li class="page-type-'.$page_type->name.'">'.
        '    <a href="'.url('action=cms/new_page&view_id='.$page_type->id.(tx('Data')->filter('cms')->menu->is_set() && tx('Data')->filter('cms')->menu->get('int') > 0 ? '&link_to='.tx('Data')->filter('cms')->menu : '')).'" title="'.$page_type->prefered_description.'">'.$page_type->prefered_title.'</a>'.
        '  </li>';
    });
    
    ?>
  </ul>

  <h2><?php __('Select an existing page'); ?></h2><br />
  
  <select name="pages" id="page-link">
    <option value=""><?php __('Select a page'); ?></option>
  <?php
  $new_page->pages->each(function($page){
    echo
      '<option value="'.$page->id.'">'.$page->title.'</option>';
  });
  ?>
  </select>

</div>

<script type="text/javascript">

$(function(){

  $("#new-page-wrap .pagetypes-list a").on("click", function(e){

    e.preventDefault();

    $.ajax({
      url: $(this).attr("href")
    }).done(function(data){

      $("#app").replaceWith(data);

      //update menu items in left sidebar
      $.ajax({url: "<?php echo url('section=cms/menu_items'); ?>"}).done(function(d){
        $("#page-main-left .content .inner").html(d);
      });

    });

  });
  
  $("#page-link").on("change", function(e){

    $.ajax({
      data: {
        page_id: $(this).val(),
        redirect: true
      },
      url: "<?php echo url('action=cms/link_page&menu_item_id='.(tx('Data')->filter('cms')->menu->is_set() && tx('Data')->filter('cms')->menu->get('int') > 0 ? tx('Data')->filter('cms')->menu : '')); ?>"
    }).done(function(data){

      $("#app").replaceWith(data);

      //update menu items in left sidebar
      $.ajax({url: "<?php echo url('section=cms/menu_items'); ?>"}).done(function(d){
        console.log(d);
        $("#page-main-left .content .inner").html(d);
      });

    });
  
  });

});

</script>
