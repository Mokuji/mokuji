<?php namespace components\cms; if(!defined('TX')) die('No direct access.');?>

<?php

$data->items

  ->not('empty')

  ->success(function($menu_items)use($data){
    echo $menu_items->as_hlist('_menu menu-items-list nestedsortable', function($item, $key, $delta, &$properties)use($data){

      $properties['data-id'] = $item->id;
      $properties['class'] = 'depth_'.$item->depth;

      return
        '<div>'.
        '  <a href="'.url('menu='.$item->id.'&pid='.$item->page_id.'&site_id='.$data->site_id, true).'">'.$item->title.'</a>'.
        '  <span class="small-icon icon-delete"></span>'.
        '</div>';
    });
  })

  ->failure(function(){
    echo '<p class="menu-items-list">';
    __('No menu items found.');
    echo '</p>';
  });

?>
