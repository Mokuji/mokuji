<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  //TODO: get_menu
  //TODO: full menu item spectrum (get/create/update/delete).
  
  protected function update_menu_items($data, $arguments)
  {
    
    return $data->each(function($item){
      
      tx('Sql')->model('menu', 'MenuItems')->set($item->having(array(
        'id' => 'item_id',
        'lft' => 'left',
        'rgt' => 'right'
      )))
      
      ->save();
      
    });
    
  }
  
  protected function create_menu_item($data, $params)
  {
    
    $data = Data($data)->having('info', 'menu_id', 'page_id', 'image_id')
      ->menu_id->validate('Menu ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
      ->page_id->validate('Page ID', array('number'=>'integer', 'gt'=>0))->back()
      ->image_id->validate('Image ID', array('number'=>'integer', 'gt'=>0))->back()
    ;
    
    string_if_null($data, 'image_id');
    
    $data->info->each(function($info, $key){
      
      $info->become(
        $info->having('title', 'description')
          ->title->validate('Title', array('required', 'string', 'not_empty'))->back()
      );
      
    });
    
    $item = tx('Sql')
      ->model('menu', 'MenuItems')
      ->merge($data->having('menu_id', 'page_id', 'image_id'))
      ->hsave(null, 0);
    
    //Go over each menu item info language.
    $data->info->each(function($info, $key)use($item){
      
      //Update info multi-language style. :>
      $item->info->{$key}->become($item->info->{$key}
        ->not('set', function($info){
          return tx('Sql')->model('menu', 'MenuItemInfo');
        })
        ->merge($info->having('title', 'description')) //Set new values.
        ->merge(array('item_id' => $item->id, 'language_id'=>$key)) //Update item_id in case of re-insert.
        ->save());
      
    });
    
    $item->merge(array(
      'title' => $item->info->{tx('Language')->get_language_id()}->title->get()
    ));
    
    return $item;
    
  }
  
  protected function update_menu_item($data, $params)
  {
    
    $data = Data($data)->having('id', 'info', 'menu_id', 'page_id', 'image_id')
      ->id->validate('ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
      ->menu_id->validate('Menu ID', array('required', 'number'=>'integer', 'gt'=>0))->back()
      ->page_id->validate('Page ID', array('number'=>'integer', 'gt'=>0))->back()
      ->image_id->validate('Image ID', array('number'=>'integer', 'gt'=>0))->back()
    ;
    
    string_if_null($data, 'image_id');
    
    $data->info->each(function($info, $key){
      
      $info->become(
        $info->having('title', 'description')
          ->title->validate('Title', array('required', 'string', 'not_empty'))->back()
      );
      
    });
    
    //Get item.
    $item = tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($data->id->get('int'))
      ->execute_single()
      
      //See if menu item exists.
      ->is('empty', function()use($data){
        return tx('Sql')
          ->model('menu', 'MenuItems')
          ->merge($data->having('menu_id', 'page_id', 'image_id'))
          ->hsave(null, 0);
      })
      
      //Check if menu_id changed.
      ->menu_id->eq($data->menu_id)
        
        //When changing menu_id we need to ensure proper lft-rgt positions.
        ->failure(function($menu_id)use($data){
          $menu_id->back()
            ->hdelete()
            ->merge($data->having('page_id', 'image_id', 'menu_id'))
            ->hsave(null, 0);
        })
        
        //When not changing menu_id, leave it out and use normal save.
        ->success(function($menu_id)use($data){
          $menu_id->back()
            ->merge($data->having('page_id', 'image_id'))
            ->save();
        })
      
      ->back();
    
    //Go over each menu item info language.
    $data->info->each(function($info, $key)use($item){
      
      //Update info multi-language style. :>
      $item->info->{$key}->become($item->info->{$key}
        ->not('set', function($info){
          return tx('Sql')->model('menu', 'MenuItemInfo');
        })
        ->merge($info->having('title', 'description')) //Set new values.
        ->merge(array('item_id' => $item->id, 'language_id'=>$key)) //Update item_id in case of re-insert.
        ->save());
      
    });
    
    $item->merge(array(
      'title' => $item->info->{tx('Language')->get_language_id()}->title->get()
    ));
    
    return $item;
    
  }
  
  public function delete_menu_item($data, $arguments)
  {
    
    $arguments->{0}->validate('Menu Item #ID', array('required', 'number' => 'int'));
    
    tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($arguments[0]->get('int'))
      ->execute_single()
      ->info->each(function($info){
        $info->delete();
      })->back()
      ->hdelete();
    
  }
  
  protected function delete_menu_item_image($data, $params)
  {
    
    tx('Sql')
      ->table('menu', 'MenuItems')
      ->pk($params[0]->get('int'))
      ->execute_single()
      
      //If this item is found.
      ->not('empty', function($item){
        
        //Delete the actual image.
        $item->image_id->not('empty', function($img_id){
          tx('Component')->helpers('media')->delete_image($img_id);
        });
        
        //Remove it from the item.
        $item->image_id->un_set();
        $item->save();
        
      });
    
  }
  
}
