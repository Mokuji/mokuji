<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

$data->items
  
  ->not('empty')
  
  ->success(function($menu_items)use($data){
    echo $menu_items->as_hlist('_menu menu-items-list nestedsortable', function($item, $key, $delta, &$properties)use($data){
      
      //Add the ID and depth to custom properties.
      $properties['data-id'] = $item->id;
      $properties['data-depth'] = $item->depth;
      
      //Add a "has-sub" class when there will be a sub-menu.
      if($delta > 0){
        $properties['class'] = 'has-sub';
      }
      
      //Return the content for the list item.
      return
        '<div>'.
        '  <span class="small-icon icon-collapse icon-toggle"></span>'.
        '  <a class="menu-item" href="'.url('menu='.$item->id.'&pid='.$item->page_id.'&site_id='.$data->site_id, true).'" data-menu-item="'.$item->id.'" data-page="'.$item->page_id.'">'.$item->title->otherwise(___('Untitled')).'</a>'.
        '  <span class="small-icon icon-delete"></span>'.
        '</div>';
        
    });
  })
  
  ->failure(function()use($names){
    echo '<ul class="menu-items-list"></ul>';
  });

?>
