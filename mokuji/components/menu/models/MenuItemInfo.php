<?php namespace components\menu\models; if(!defined('TX')) die('No direct access.');

class MenuItemInfo extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'menu_item_info',
    
    $relations = array(
      'MenuItems' => array('item_id' => 'MenuItems.id')
    );

}