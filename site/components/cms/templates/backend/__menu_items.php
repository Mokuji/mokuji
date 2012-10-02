<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<nav id="menu-items-toolbar">

  <?php if($data->sites->size() > 1){ ?>
    <ul class="_menu toolbar">
      <li>
        <?php echo $data->sites->as_options('site_id', 'title', 'id', array(
          'id'=>'btn-select-site',
          'force_choice'=>true,
          'default'=>$data->site_id)
        ); ?>
      </li>
      <li><a href="<?php echo url('view=cms/sites&menu=NULL&pid=NULL'); ?>" id="btn-edit-sites"><?php __('Edit sites'); ?></a></li>
    </ul>
  <?php } ?>

  <ul class="_menu toolbar">
    <li><a href="<?php echo url('section=cms/app&menu=0', true); ?>" id="btn-new-menu-item"><?php __('New menu item'); ?></a></li>
    <li><a href="<?php echo url('section=cms/menu_items'); ?>" id="btn-refresh-menu-items"><?php __('Refresh menu items'); ?></a></li>
    <li class="menu-state" id="dropdown-menu">

      <a href="#" id="btn-save-menu-items"><?php __('Save menu items'); ?></a>
      <a href="#" id="user-message"><?php __('Saved successfully'); ?></a>

      <?php
      //Menu select.
      if($data->menus->size() > 1){
        echo $data->menus->as_options('menu_id', 'title', 'id', array(
          'id'=>'btn-select-menu',
          'force_choice'=>true,
          'default'=>$data->menu_id
        ));
      }elseif($data->menus->size() == 1){
        //If only one menu -> hide menu select box.
        echo '<input type="hidden" name="menu_id" value="'.$data->menus->{0}->id.'">';
      }
      ?>

    </li>
  </ul>
</nav>

<?php

$data->items

  ->not('empty')

  ->success(function($menu_items)use($data){
    echo $menu_items->as_hlist('_menu menu-items-list nestedsortable', function($item, $key, $delta, &$properties)use($data){

      $properties['class'] = 'depth_'.$item->depth;

      return
        '<div>'.
        '  <a href="'.url('menu='.$item->id.'&pid='.$item->page_id.'&site_id='.$data->site_id, true).'">'.$item->title.'</a>'.
        '  <span href="'.url('action=menu/menu_item_delete&item_id='.$item->id).'" class="small-icon icon-delete"></span>'.
        '</div>';
    });
  })

  ->failure(function(){
    //__('No menu items found.');
  });

?>

<script type="text/javascript">

  $(function(){
		
    /* =Select site
    -------------------------------------------------------------- */
    $("#btn-select-site").on('change', function(e){
      
      $.ajax({
        url: '?section=cms/menu_items&site_id='+$(e.target).val()
      }).done(function(d){
        $("#page-main-left .content .inner").html(d);
        app.init();
      });
      
    });
    
    /* =Select menu
    -------------------------------------------------------------- */
    $("#btn-select-menu").on('change', function(e){
      
      $.ajax({
        url: '?section=cms/menu_items&menu_id='+$(e.target).val()
      }).done(function(d){
        $("#page-main-left .content .inner").html(d);
        app.init();
      });
      
    });
    
    /* =New menu item
    -------------------------------------------------------------- */
    $("#btn-new-menu-item").on('click', function(e){

      e.preventDefault();

      $.ajax({
        url: $(this).attr('href')
      }).done(function(d){
        $("#page-main-right").html(d);
      });

    });

    /* =Revert/refresh menu
    -------------------------------------------------------------- */
    $("#btn-refresh-menu-items").on('click', function(e){

      e.preventDefault();

      $.ajax({
        url: $(this).attr('href')
      }).done(function(d){
        $("#page-main-left .content .inner").html(d);
        app.init();
      });

    });

    /* =Delete menu item
    -------------------------------------------------------------- */
    $(".menu-items-list .icon-delete").on("click", function(){

      if(confirm("Weet u zeker dat u dit menu-item wilt verwijderen?")){

        var _this = $(this);

        $.ajax({
          url: $(this).attr("href")
        }).done(function(){
          $(_this).closest("li").slideUp();
        });

      }

    });

	});


</script>
