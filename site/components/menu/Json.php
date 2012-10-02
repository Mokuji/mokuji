<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{

  
  protected function update_menu_items($data, $arguments)
  {
    
    return $data->each(function($item){
      
      tx('Sql')->model('menu', 'MenuItems')->set($item->having(array(
        'id' => 'item_id',
        'lft' => 'left',
        'rgt' => 'right'
      )))
      
      ->save();
      
    });
    
  }

  

}
