<?php namespace components\cms\models; if(!defined('TX')) die('No direct access.');

class Pages extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'cms_pages',
  
    $relations = array(
      'Components' => array('view_id' => 'ComponentViews.id'),
      'ComponentViews' => array('view_id' => 'ComponentViews.id'),
      'Themes' => array('theme_id' => 'Themes.id'),
      'Templates' => array('template_id' => 'Templates.id'),
      'Layouts' => array('layout_id' => 'Layouts.id'),
      'LayoutInfo' => array('layout_id' => 'LayoutInfo.layout_id'),
      'OptionSets' => array('optset_id' => 'OptionSets.id'),
      'MenuItems' => array('id' => 'MenuItems.page_id'),
      'Modules' => array('id' => 'ModulePageLink.page_id'),
      'PageInfo' => array('id' => 'PageInfo.page_id'),
      'PageGroupPermissions' => array('id' => 'PageGroupPermissions.page_id')
    );
  
  protected function get_prefered_title()
  {
    
    return tx('Sql')
      ->table('cms', 'PageInfo')
      ->where('page_id', $this->id)
      ->where('language_id', tx('Language')->id)
      ->execute_single()
      ->title
      ->is('empty', function(){
        return $this->title;
      });
    
  }
  
  protected function get_menu_items()
  {
  
    return tx('Sql')->table('menu', 'MenuItems')
      ->where('page_id', $this->id)
      ->join('MenuItemInfo', $mii)
    ->workwith($mii)
      ->select("title", 'title')
      ->where('language_id', tx('Language')->get_language_id())
    ->execute();
  
  }
  
  public function get_info()
  {

    $ret = Data();

    $this->table('PageInfo')
    ->where('page_id', $this->id)
    ->execute()
    ->each(function($row)use(&$ret){
      $ret[$row->language_id] = $row;
    });

    return $ret;

  }
  
  public function get_component_view()
  {
    
    return tx('Sql')
      ->table('cms', 'ComponentViews')
      ->pk($this->view_id)
      ->execute_single();
    
  }

}
