<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
    );
  
  protected function save_item($data)
  {
    
    $item_id = 0;
    tx($data->id->get('int') > 0 ? 'Updating a text item.' : 'Adding a new text item', function()use($data, &$item_id){
      
      //Append user object for easy access.
      $user_id = tx('Data')->session->user->id;

      $data->order_nr = $data->order_nr->otherwise(0);

      //Save item.
      $item = tx('Sql')->table('text', 'Items')->pk($data->id->get('int'))->execute_single()->is('empty')
        ->success(function()use($data, $user_id, &$item_id){
          tx('Sql')->model('text', 'Items')->merge($data->having('page_id', 'order_nr'))->merge(array('dt_created' => date("Y-m-d H:i:s")))->merge(array('user_id' => $user_id))->save();
          $item_id = mk('Sql')->get_insert_id();
        })
        ->failure(function($item)use($data, $user_id, &$item_id){
          $item->merge($data->having('page_id', 'order_nr', 'dt_created'))->merge(array('user_id' => $user_id))->save();
          $item_id = $item->id->get('int');
        });

      //Delete existing item info.
      tx('Sql')->table('text', 'ItemInfo')->where('item_id', $item_id)->execute()->each(function($row){
        $row->delete();
      });

      //Save item info.
      $data->info->each(function($info)use($data, $item_id){

        $language_id = $info->key();
        tx('Sql')->model('text', 'ItemInfo')->set($info->having('title', 'description', 'text'))->merge(array('item_id' => $item_id, 'language_id' => $language_id))->save();

      });

    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    echo $item_id;exit;
    // tx('Url')->redirect(url('item_id=NULL'));
    
  }

  //Export all text items to a document.
  protected function export_to_doc()
  {
    throw new \exception\Deprecated();
  }

}
