<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{

  /**
   * Returns a result set with the menu items you asked for.
   * 
   * @param array $options Array with options.
   *  @key int $site_id              - The site ID to load the menu from from.
   *  @key int $template_key         - The menu's template_key to select items from.
   *  @key int $parent_pk            - The menu item id to select submenu items from.
   *  @key int $min_depth            - Minimum depth to show items from.
   *  @key int $max_depth            - Number that indicates how far in submenus it should go.
   *  @key bool $display_select_menu - If true: a select menu will be returned.
   *  @key bool $no_active           - If false: suppresses the "active" class on active menu items.
   *  @key bool $no_selected         - If false: suppresses the "selected" class on selected menu items.
   */
  protected function menu($options)
  {

    $menu_items = $this->helper('get_menu_items', $options);
    
    #TEMP: Default options.
    $options = Data(array(
      'show_unlinked' => false,
      'show_unauthorised' => false
    ))->merge($options);
    
    //Create menu.
    $menu =

      $menu_items

        ->not('empty')

        //If menu items are found:
        ->success(function($items)use($options){
          
          //Get the selected items.
          $selected_items = tx('Sql')
            ->table('menu', 'MenuItems')
            ->where('page_id', tx('Data')->get->pid->get('int'))
            ->execute();
          
          //Show a 'select menu'.
          if($options->display_select_menu->get('bool') == true){
            return $items->as_options('menu', 'title', 'id', array(
              'placeholder_text' => __('Select a season', 1),
              'rel' => 'page_id',
              'default' => tx('Data')->get->menu
            ));
          }
          
          //Figure out the class string.
          $classes = '_menu'.($options->classes->is_set() ? ' '.$options->classes->get() : '');
          
          //Show a normal menu.
          return $items->as_hlist($classes, function($item, $key, $delta, &$properties)use(&$active_depth, $selected_items, $options){
            
            //Test if we are allowed to view this item.
            if(1
              && ($item->page_id->is_set() || $options->show_unlinked->get('bool') == true)
              && (tx('Component')->helpers('cms')->check_page_authorisation($item->page_id) || $options->show_unauthorised->get('bool') == true)
            ){
              
              $properties['class'] = '';
              
              //Add class 'active' if this is the active menu item.
              if($options->no_active->get() != true && $item->page_id->get('int') === tx('Data')->get->pid->get('int')){
                $properties['class'] .= ' active';
                $active_depth = $item->depth->get('int');
              }
              
              //Add class 'selected' if this is a selected item.
              if(1
                && $options->no_selected->get() != true
                && $selected_items->any(function($v)use($item){ return ($item->lft->get() <= $v->lft->get() && $item->rgt->get() >= $v->rgt->get()); })
              ){
                $properties['class'] .= ' selected';
              }
              
              if($delta < 0 && $item->depth->get('int') == $active_depth -1 || $item->depth->get('int') - $active_depth >= 1){
                $active_depth = null;
              }
              
              $properties['class'] = trim($properties['class']);
              
              return '<a href="'.url('pid='.$item->page_id, true).'">'.$item->title.'</a>';
            }
            
            //Since we do not have permissions for this item, hide it.
            else{
              $properties['style'] = 'display:none;';
            }

          });

        })

        ->failure(function(){
          echo '<!-- '.__('No menu items found.', 1).' -->';
        });

    return array(
      'menu' => $menu
    );

  }

  protected function menu_image($options)
  {
    return
      tx('Sql')
      ->table('menu', 'MenuItems')
      ->where('page_id', tx('Data')->get->pid->get('int'))
      ->execute_single();
  }

  protected function breadcrumbs($options)
  {
    
    return;
    throw new \exception\Programmer('Breadcrumbs under construction.');
    
    $options
      ->page_id->validate('Page #ID', array('number', 'gt'=>0))->back()
      ->menu_id->validate('Menu #ID', array('number', 'gt'=>0))->back();
  
    //Get all active menu items.
    $active = tx('Sql')->table('menu', 'MenuItems')
      ->where('page_id', $options->page_id)
      ->where('menu_id', $options->menu_id)
      ->execute();
    
    
    
    
    
    
    //OLD
    
    $menu_item_info =
      tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($options->menu_item_id)
      ->execute_single();


    
    tx('Sql')

      ->table('menu', 'MenuItems', $mi)

        //filter menu
        ->sk(tx('Data')->filter('menu')->menu_id->is_set() ? tx('Data')->filter('menu')->menu_id : '1')
      
        //join menu item info
        ->join('MenuItemInfo', $mii)->inner()

      ->workwith($mii)

        ->select('title', 'title')
        ->where('language_id', tx('Language')->get_language_id())
        
      ->workwith($mi)
      
        ->where('lft', '<=', $menu_item_info->lft)
        ->where('rgt', '>=', $menu_item_info->rgt)
        ->order('lft', 'ASC')

      ->execute();

  }

  protected function sitemap($options)
  {

    $menu_items = $this->helper('get_menu_items', $options);


    //Create sitemap.
    $sitemap =

      $menu_items

        ->not('empty')

        //If menu items are found:
        ->success(function($items)use($options){   

          $is_home = true;
          return $items->as_hlist(array('classes' => '_menu col5'.($options->classes->is_set() ? $options->classes->get() : ''), 'id' => 'primaryNav'), function($item, $key, $delta, &$properties)use(&$active_depth, &$is_home){
            if(tx('Account')->check_level($item->access_level->get('int'))){

              $properties['class'] = '';
              if($is_home){
                $properties['class'] = 'is-home';
                $is_home = false;
              }

              //Add class 'active' if this is the active menu item.
              if($item->id->get('int') === tx('Data')->get->menu->get('int')){
                $properties['class'] .= ' active';
                $active_depth = $item->depth->get('int');
              }
              //Add class 'selected' if this is an selected item.
              if($delta < 0 && $item->depth->get('int') == $active_depth -1 || $item->depth->get('int') - $active_depth >= 1){
                $active_depth = null;
              }
              if(!is_null($active_depth)){
                // $properties['class'] .= ' selected';
              }

              return '<a href="'.url('menu='.$item->id.'&pid='.$item->page_id, true).'">'.$item->title.'</a>';
            }

          });

        })

        ->failure(function(){
          echo '<!-- '.__('No menu items found.', 1).' -->';
        });

    return $sitemap;

  }

}
