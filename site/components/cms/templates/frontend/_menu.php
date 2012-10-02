<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); ?>

<ul class="_menu">
  
  <?php 
  foreach($menu->items as $item)
  {
    
    $published = $item->published;
    
    if($item->page_id->is_set()){
      $href = url('pid='.$item->page_id, true);
    }
    
    else{
      $href = url('menu='.$item->id, true);
      $published = false;
    }
    
    if($published || EDITABLE || tx('Config')->system()->check('backend')){
      echo "\n".'<li><a href="'.$href.'">'.$item->title.'</a></li>';
    }
    
  }
  
  ?>
  
</ul>