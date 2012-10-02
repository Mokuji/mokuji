<?php namespace components\text\models; if(!defined('TX')) die('No direct access.');

class Items extends \dependencies\BaseModel
{
  
  protected static
  
    $table_name = 'text_items',
  
    $relations = array(
      'ItemInfo' => array('id' => 'ItemInfo.item_id')
    );

  public function get_info()
  {

    $ret = Data();

    $this->table('ItemInfo')
    ->where('item_id', $this->id)
    ->execute()
    ->each(function($row)use(&$ret){
      $ret[$row->language_id] = $row;
    });

    return $ret;

  }

}