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

  public function delete_menu_item($data, $arguments)
  {
    
    $arguments->{0}->validate('Menu Item #ID', array('required', 'number' => 'int'));
    
    tx('Sql')->table('menu', 'MenuItems')->pk($arguments[0]->get('int'))->execute()->{0}->hdelete();
    
  }

}
