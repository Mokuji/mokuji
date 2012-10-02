<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

<ul class="clearfix">

<?php

$data
  ->menu_items
  ->not('empty')
  ->success(function($items)use(&$last_menu_item){
    $items->each(function($item, $i)use(&$last_menu_item){
      echo '  <li><a href="'.url('menu='.$item->id.'&pid='.$item->page_id, true).'">'.$item->title.'</a></li>';
      $last_menu_item = $item->title;
    });
  })

  ->failure(function(){
    __('<!-- No breadcrumb items found. -->');
  });

?>

</ul>