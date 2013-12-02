<?php namespace components\cms; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'register' => 0,
      'simple_login' => 0,
      'feedback_form' => 0
    );
  
  protected function menus($options)
  {
    
    return array(
      'menus' => $this->section('menus'),
      'items' => $this->section('menu_items'),
      'configbar' => $this->section('configbar')
    );
    
  }
 
  protected function menu($options)
  {

    return array(
      'editable' => $this->helper('is_website_editable'),
      'items' => tx('Sql')
      ->table('cms', 'MenuItems')
        ->sk(tx('Data')->filter('cms')->menu_id->is_set() ? tx('Data')->filter('cms')->menu_id : '1')
        ->add_absolute_depth('depth')
        ->join('MenuItemInfo', $mii)->inner()
      ->workwith($mii)
        ->select('title', 'title')
        ->where('language_id', tx('Language')->get_language_id())
      ->execute()
    );
  
  }
  
  protected function simple_login()
  {
  
    return array(
      'href' => url('?action=cms\logout')
    );
  
  }
  
  protected function register($options)
  {
    
    return array();
    
  }
 
  protected function feedback_form()
  {
    return array();
  }
  
}
