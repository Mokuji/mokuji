<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'menu_link' => 0,
      'external_url' => 0
    );
  
  protected function menus($return=null)
  {    
    return array(
      'menu_item_list' => $this->section('menu_item_list'),
      'menu_item_edit' => $this->section('menu_item_edit')
    );
  }
  
  protected function menu_link($options)
  {
    
    $pid =
      ($options->pid->is_set() ? $options->pid->value : tx('Data')->filter('cms')->pid);
    
    $link = tx('Sql')
      ->table('cms', 'MenuLinks')
      ->pk($pid)
      ->execute_single();
    
    //On backend, give the options.
    if(tx('Config')->system('backend')->get()){
      return array(
        'link' => $link,
        'menu_items' => tx('Sql')
          ->table('menu', 'MenuItems', $MI)
          ->order('menu_id')
          ->order('lft')
          ->join('MenuItemInfo', $MII)
          ->select("$MII.title", 'title')
          ->where("$MII.language_id", tx('Language')->get_language_id())
          ->execute($MI)
      );
    }
    
    //On frontend, execute the link.
    else
    {
      
      //Check if a page is linked to the target menu item.
      $link->menu_item->is('empty', function(){
        throw new \exception\Expected('No page linked to target menu item.');
      });
      
      //Execute the selected action.
      switch($link->link_action->get()){
        
        //Redirect
        case 0:
          tx('Url')->redirect('menu='.$link->menu_item_id->get('int').'&pid='.$link->menu_item->page_id->get('int'));
          return;
        
        //Copy content
        case 1:
          #TODO: Wait what? Shouldn't this copy content?
          tx('Url')->redirect('pid='.$link->menu_item->page_id->get('int'));
          return;
        
      }
      
    }
    
    
  }
  
  protected function external_url($options)
  {
    
    $pid =
      ($options->pid->is_set() ? $options->pid->value : tx('Data')->filter('cms')->pid);
    
    $link = tx('Sql')
      ->table('menu', 'MenuItems')
      ->where('page_id', $pid)
      ->execute_single();
    
    $link->is('empty', function(){
      throw new \exception\Expected('We couldn\'t find a menu item linked to this \'external url\'-page.');
    });

    return $link;
   
  }

}
