<?php namespace components\menu\models; if(!defined('TX')) die('No direct access.');

class MenuItems extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'menu_items',
  
    $relations = array(
      'MenuItemInfo' => array('id' => 'MenuItemInfo.item_id'),
      'Menus' => array('menu_id' => 'MenuInfo.id'),
      'Pages' => array('page_id' => 'Cms.Pages.id')
    ),
    
    $hierarchy = array(
      'left' => 'lft',
      'right' => 'rgt'
    ),
    
    $secondary_keys = array(
      'menu_id'
    );
  
  public function get_info()
  {
    
    $ret = Data();
    
    $this->table('MenuItemInfo')
    ->where('item_id', $this->id)
    ->execute()
    ->each(function($row)use(&$ret){
      $ret->{$row->language_id}->become($row);
    });
    
    return $ret;
    
  }

  public function get_image()
  {
    
    if(!tx('Component')->available('media'))
      return false;
    
    $image = tx('Sql')
      ->table('media', 'Images')
      ->pk($this->image_id)
      ->execute_single();
    
    if($image->is_empty())
      return false;
    
    $resizeType = tx('Config')->user('menu.menu_item_thumbnail.resize-type')->get() == 'fit' ? 'fit' : 'fill';
    $resizeWidth = tx('Config')->user('menu.menu_item_thumbnail.resize-width')->otherwise(220)->get('int');
    $resizeHeight = tx('Config')->user('menu.menu_item_thumbnail.resize-height')->otherwise(150)->get('int');
    
    return array(
      'id' => $image->id,
      'url' => (string)$image->generate_url(array(
          $resizeType.'_width' => $resizeWidth,
          $resizeType.'_height' => $resizeHeight,
        ), array('allow_growth')),
      'image' => $image
    );
    
  }

  public function is_unique_link()
  {
    
    //See if there are others out there.
    return $this->table('MenuItems')
      ->where('id', '!', $this->id)
      ->where('page_id', $this->page_id)
      ->count()->get('int') === 0;
    
  }

}
