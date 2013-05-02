<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
    );
  
  protected function menu_item_list($options)
  {
    
    //Access level 2, since it has no permission filtering.
    
    return tx('Sql')
      ->table('cms', 'MenuItems')
        ->sk(tx('Data')->filter('cms')->menu_id->is_set() ? tx('Data')->filter('cms')->menu_id : '1')
        ->add_absolute_depth('depth')
        ->join('MenuItemInfo', $mii)->inner()
      ->workwith($mii)
        ->select('title', 'title')
        ->where('language_id', tx('Language')->get_language_id())
      ->execute();
  }

  protected function menu_item_edit($options)
  {

    return array(
      'item' => $this->table('MenuItems')->join('MenuItemInfo', $ii)->left()->select("$ii.title", 'title')->select("$ii.description", 'description')->pk(tx('Data')->get->item_id)->execute_single()
    );

  }
  
}
