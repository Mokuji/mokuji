<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected function get_items($filter, $params)
  {

    $that = $this;
    
    return
      $that->table('Items')
      ->is($filter->id->gt(0)->and_is('set')->and_not('empty'), function($q)use($filter){
        $q->where('id', $filter->id);
      })
      ->is($filter->pid->is('set'), function($q)use($filter){
        $q->where('page_id', $filter->pid->get('int'));
      })
      ->execute()
      ->each(function($row){
        $row->info->set($row->info);
      });

  }
  
  protected function update_page_text($data, $params)
  {
    
    $item_id = 0;
    
    //Append user object for easy access.
    $user_id = tx('Data')->session->user->id;

    $data->order_nr = $data->order_nr->otherwise(0);

    //Save item.
    $item = tx('Sql')->table('text', 'Items')->pk($data->id->get('int'))->execute_single()->is('empty')
      ->success(function()use($data, $user_id, &$item_id){
        tx('Sql')->model('text', 'Items')->merge($data->having('page_id', 'order_nr'))->merge(array('dt_created' => date("Y-m-d H:i:s")))->merge(array('user_id' => $user_id))->save();
        $item_id = mysql_insert_id();
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

    return $item_id;
    
  }
  
  
}
