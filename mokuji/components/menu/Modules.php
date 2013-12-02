<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'menu' => 0,
      'menu_image' => 0,
      'breadcrumbs' => 0
    );
  
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
   *  @key bool $keep_menu           - If true: keeps the current menu key in the URL. Only the pid renews.
   *  @key bool $no_active           - If true: suppresses the "active" class on active menu items.
   *  @key bool $no_selected         - If true: suppresses the "selected" class on selected menu items.
   *  @key bool $select_from_root    - If true: select items from root.
   *             tx('Data')->get->menu will be used to calculate root.
   *             $parent_pk, $template_key and $site_id will be overwritten.
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
        ->menu_items
        ->not('empty')

        //If menu items are found:
        ->success(function($items)use($options, $menu_items){
          
          //Get the selected items.
          $selected_items = tx('Sql')
            ->table('menu', 'MenuItems')
            ->where('page_id', tx('Url')->url->data->pid->get('int'))
            ->execute();
          
          //Show a 'select menu'.
          if($options->display_select_menu->get('bool') == true){

            $items->convert('filter', function($item)use($options){

              $access = false;

              if(1
                 && ($item->page_id->is_set() || $options->show_unlinked->get('bool') == true)
                 && (tx('Component')->helpers('cms')->check_page_authorisation($item->page_id) || $options->show_unauthorised->get('bool') == true)
              ){
                $access = true;
              }

              return $access;

            });

            return $items->as_options('menu', 'title', 'id', array(
              'placeholder_text' => __('Select a season', 1),
              'rel' => 'page_id',
              'default' => ($menu_items->root_item->otherwise(tx('Component')->helpers('menu')->call('get_active_menu_item')->id))
            ));

          }
          
          //Figure out the class string.
          $classes = '_menu'.($options->classes->is_set() ? ' '.$options->classes->get() : '');
          
          //Show a normal menu.
          $method = $options->as_hoptions->is_true() ? 'as_hoptions' : 'as_hlist';
          return $items->{$method}(array('id'=>null, 'classes'=>$classes, 'value-location'=>$options->as_hoptions->is_true()), function($item, $key, $delta, &$properties)use(&$active_depth, $selected_items, $options, $items){
            
            //Workaround for conversion to Data (instead of preserving model).
            $item = $items[$key];
            
            //Test if we are allowed to view this item.
            if(1
              && ($item->page_id->is_set() || $options->show_unlinked->get('bool') == true)
              && (tx('Component')->helpers('cms')->check_page_authorisation($item->page_id) || $options->show_unauthorised->get('bool') == true)
            ){
              
              $properties['class'] = '';
              
              //Add class 'active' if this is the active menu item.
              if($options->no_active->get() != true && $item->page_id->get('int') === tx('Url')->url->data->pid->get('int')){
                $properties['class'] .= ' active';
                $active_depth = $item->depth->get('int');
              }
              
              //Add class 'selected' if this is a selected item.
              if(1
                && $options->no_selected->get() != true
                && $selected_items->any(function($v)use($item){ return ($item->menu_id->get() == $v->menu_id->get() && ($item->lft->get() <= $v->lft->get() && $item->rgt->get() >= $v->rgt->get())); })
              ){
                $properties['class'] .= ' selected';
                if($options->as_hoptions->is_true())
                  $properties['selected'] = 'selected';
              }
              
              if($delta < 0 && $item->depth->get('int') == $active_depth -1 || $item->depth->get('int') - $active_depth >= 1){
                $active_depth = null;
              }
              
              $properties['class'] = trim($properties['class']);
              
              if($options->as_hoptions->is_true()){
                $properties['value'] = (string)url('pid='.$item->page_id.($options->keep_menu->get() == false ? '&menu='.$item->id : '&menu=KEEP'), true);
                return $item->depth->get() <= $options->max_depth->get() ? $item->title->get() : false;
              } else {
                return $item->depth->get() > $options->max_depth->get() ? false :
                  '<a href="'.
                    \components\cms\routing\UrlFormatFactory::format('/?pid='.$item->page_id)
                      ->output(array(
                        'menu' => ($options->keep_menu->get() == false ? ($item->is_unique_link() ? null : $item->id) : mk('Url')->url->menu->get())
                      )).
                  '">'.$item->title.'</a>';
              }
              

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
      ->where('page_id', tx('Url')->url->data->pid->get('int'))
      ->execute_single();
  }

  protected function breadcrumbs($options)
  {
    
    // return;
    // throw new \exception\Programmer('Breadcrumbs under construction.');
    
    // $options
    //   ->page_id->validate('Page #ID', array('number', 'gt'=>0))->back()
    //   ->menu_id->validate('Menu #ID', array('number', 'gt'=>0))->back();
  
    // //Get all active menu items.
    // $active = tx('Sql')->table('menu', 'MenuItems')
    //   ->where('page_id', $options->page_id)
    //   ->where('menu_id', $options->menu_id)
    //   ->execute();
    
    //OLD
    
    $menu_item_info =
      tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($options->menu_item_id)
      ->execute_single();

    return tx('Sql')

      ->table('menu', 'MenuItems', $mi)

        //filter menu
        ->sk($menu_item_info->menu_id)
      
        //join menu item info
        ->join('MenuItemInfo', $mii)->inner()

      ->workwith($mii)

        ->select('title', 'title')
        ->where('language_id', tx('Language')->get_language_id())
        
      ->workwith($mi)
      
        ->where('lft', '<=', $menu_item_info->lft)
        ->where('rgt', '>=', $menu_item_info->rgt)
        ->order('lft', 'ASC')
        
        ->group('lft')

      ->execute();
      
  }
  
}
