<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

$data->items
  
  ->not('empty')
  
  ->success(function($menu_items)use($data){
    echo $menu_items->as_hlist('_menu menu-items-list nestedsortable', function($item, $key, $delta, &$properties)use($data){

      $properties['data-id'] = $item->id;
      $properties['class'] = 'depth_'.$item->depth;

      return
        '<div>'.
        '  <a class="menu-item" href="'.url('menu='.$item->id.'&pid='.$item->page_id.'&site_id='.$data->site_id, true).'" data-menu-item="'.$item->id.'" data-page="'.$item->page_id.'">'.$item->title.'</a>'.
        '  <span class="small-icon icon-delete"></span>'.
        '</div>';
    });
  })
  
  ->failure(function()use($names){
    echo '<p class="menu-items-list">';
    __($names->component, 'No menu items found');
    echo '.</p>';
  });

?>
