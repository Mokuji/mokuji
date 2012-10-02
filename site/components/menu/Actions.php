<?php namespace components\menu; if(!defined('TX')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{

  protected function new_menu($data)
  {
    
    $data->menu_name->add_rules(array('required', 'string', 'no_html'))->validate(true)
    
    ->success(function($name){
      $record = tx('Sql')->model('cms', 'Menus')->set(array('title'=>$name))->save();
      echo $record->id;
    })
    
    ->failure(function($d){
      throw new \exception\Validation('%s', $e->validation_errors());
    });
    
    tx('Url')->redirect('menu_name=NULL');
    
  }
  
  protected function delete_menu($data)
  {
    
    $model = tx('Sql')->model('menu', 'Menus');
    $model->merge($data->having($model->pks(true), $model->sks(true)))->delete();
    
  }

  protected function menu_item_delete($data)
  {
    
    tx('Deleting menu item.', function()use($data){
      
      //delete menu item
      tx('Sql')->table('menu', 'MenuItems')->pk($data->item_id)->execute_single()->not('set', function(){
        throw new \exception\EmptyResult('Could not retrieve the menu item you were trying to delete. This could be because the ID was invalid.');
      })
      ->hdelete();

      //delete menu item info
      tx('Sql')->table('menu', 'MenuItemInfo')->where('item_id', "'{$data->item_id}'")->execute()
      ->is('empty', function()use($data){
        //mwah.
      })
      ->each(function($row){
        $row->delete();
      });
      
    })
    
    ->failure(function($info){
      tx('Session')->new_flash('error', $info->get_user_message());
    });
    
  }
  
}