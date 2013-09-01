<?php namespace components\menu\models; if(!defined('TX')) die('No direct access.');

class Menus extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'menu_menus',
  
    $relations = array(
      'MenuItems' => array('id' => 'MenuItems.menu_id')
    );
    
    
}