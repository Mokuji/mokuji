<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'get_menu_items' => 0,
      'get_root_item' => 0
    );
  
  /**
   * Returns a result set with the menu items you asked for.
   * 
   * @param array $options Array with options.
   *  @key int $site_id The site ID to load the menu from from.
   *  @key int $template_key The menu's template_key to select items from.
   *  @key int $parent_pk The menu item id to select submenu items from.
   *  @key int $min_depth Minimum depth to show items from.
   *  @key int $max_depth Number that indicates how far in submenus it should go.
   *  @key bool $display_select_menu If true: a select menu will be returned.
   *  @key bool $select_from_root If true: select items from root.
   *             tx('Data')->get->menu will be used to calculate root.
   *             $parent_pk, $template_key and $site_id will be overwritten.
   */
  public function get_menu_items($options = null)
  {

    //Get menu.
    $menu = tx('Sql')
      ->table('menu', 'Menus')
      ->is($options->site_id->is('set')->and_not('empty'), function($q)use($options){
        $q->where('site_id', $options->site_id->otherwise(tx('Site')->id));
      })
      ->is($options->template_key->is_set(), function($table)use($options){
        $table->where('template_key', "'{$options->template_key}'");
      })
      ->execute_single();

    $root_item = $this->helper('get_root_item', Data($options)->merge(array('menu_id' => $menu->id)));
   
    //Overwrite parent_pk is you want to select from root.
    if($options->select_from_root->is_set()){
      $options->parent_pk = $root_item;
    }

    //Get menu items.
    $menu_items =
      
      tx('Sql')
        
        ->table('menu', 'MenuItems')
          
          //filter menu.
          ->sk($menu->id->get())
          
          //add absolute depth.
          ->add_absolute_depth('depth')
          
          //set the menu item id to select submenu items from.
          ->is($options->parent_pk->is('set')->and_not('empty'), function($q)use($options){
            $q->parent_pk($options->parent_pk->get('int'));
          })
            
          //set minimum depth to show.
          ->is($options->min_depth->is('set'), function($q)use($options){
            $q->where('depth', '>=', $options->min_depth->get('int'));
          })

          //set how far in submenus it should go. 3 will let it go on to a sub-sub-sub menu and no further.
          ->is($options->max_depth->is('set'), function($q)use($options){
            $q->max_depth($options->max_depth->get('int'));
          })
                    
          //join menu item info.
          ->join('MenuItemInfo', $mii)->inner()
          
          //join page.
          ->join('Pages', $p)
          ->select("$p.access_level", 'access_level')
          
        ->workwith($mii)
        
          ->select('title', 'title')
          ->where('language_id', tx('Language')->get_language_id())

        ->execute();

    return Data(array(
      'menu_items' => $menu_items,
      'root_item' => $root_item
    ));

  }

  public function get_root_item($options)
  {

    $options->menu_item_id = ($options->menu_item_id->is('set')->get('bool') ? $options->menu_item_id : tx('Data')->get->menu);

    //if $select_from_root is true: select root item to show items from.
    $no_menu_items_found = false;

    $root_item = null;
    if($options->menu_item_id->get() > 0)
    {

      tx('Sql')->table('menu', 'MenuItems')
        ->pk($options->menu_item_id)
        ->execute_single()
        ->not('empty', function($item)use($options, &$root_item){

          tx('Sql')

            ->table('menu', 'MenuItems')

            //filter menu.
            ->sk($options->menu_id->is_set() ? $options->menu_id : '1')

            //add absolute depth.
            ->add_absolute_depth('depth')
            
            //set minimum depth to show.
            ->is($options->min_depth->is('set'), function($q)use($options){
              $q->where('depth', '>=', $options->min_depth->get('int'));
            })

            ->where('lft', '<', $item->lft)
            ->where('rgt', '>', $item->rgt)
            ->order('lft')
            ->limit(1)
            ->execute_single()
            ->is('empty', function()use($options, &$root_item){
                $root_item = $options->menu_item_id;
              })->failure(function($row)use($options, &$root_item){
                $root_item = $row->id;
              });

      })->failure(function()use(&$no_menu_items_found){
        $no_menu_items_found = true;
      });

    }
    
    if($no_menu_items_found){
      return false;
    }else{
      return $root_item;
    }

  }

}
