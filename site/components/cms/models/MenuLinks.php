<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class MenuLinks extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_menu_links',
  
    $relations = array(
      'MenuItem' => array('menu_item_id' => 'MenuItem.id')
    );
  
  public function get_menu_item()
  {
    
    return tx('Sql')
      ->table('cms', 'MenuItems')
      ->pk($this->menu_item_id)
      ->execute_single();
    
  }

}
