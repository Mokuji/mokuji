<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected function get_items($filter, $params)
  {
    
    //Remember this.
    $that = $this;
    
    //Query for Items.
    return $that->table('Items')
    
    //Add a filter for "id" when it is given.
    ->is($filter->id->gt(0)->and_is('set')->and_not('empty'), function($q)use($filter){
      $q->where('id', $filter->id);
    })
    
    //Add a filter for page ID when it is given.
    ->is($filter->pid->is('set'), function($q)use($filter){
      $q->where('page_id', $filter->pid->get('int'));
    })
    
    //Execute the query.
    ->execute_single()
    
    //Is it empty?
    ->is('empty')
    
    //Then go away.
    ->success(function(){
      throw new \exception\EmptyResult('Text is not in the database.');
    })
    
    //Else, make sure the info is included.
    ->failure(function($r){
      $r->info;
    });
    
  }
  
  protected function update_page_text($data, $params)
  {
    
    //Append user object for easy access.
    $user_id = tx('Data')->session->user->id;
    
    //Set a default order number.
    $data->order_nr = $data->order_nr->otherwise(0);
    
    //New item?
    $new = false;
    
    //Get the item of the given ID.
    $item = tx('Sql')->table('text', 'Items')->pk($data->id->get('int'))->execute_single()
    
    //Test if it does not exist.
    ->is('empty')
    
    //If it doesn't, create a new row.
    ->success(function()use($data, $user_id, &$item_id, &$new){
      
      //Create a new row.
      $new = tx('Sql')->model('text', 'Items')
      
      //Merge data.
      ->merge($data->having('page_id', 'order_nr'))
      ->merge(array(
        'dt_created' => date("Y-m-d H:i:s"),
        'user_id' => $user_id)
      )
      
      //Save to database.
      ->save();
      
      //Get the ID.
      $item_id = $new->id->get('int');
      
    })
    
    //If it does.. update the existing row.
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
    
    //Return the inserted item.
    return ($new ? $new : $item);
    
  }
  
  
}
