<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class Entries extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_entries',
    
    $relations = array(
      'EntriesToTimelines' => array('id' => 'EntriesToTimelines.entry_id')
    ),
    
    $validate = array(
      'id' => array('required', 'number'=>'int', 'gt'=>0),
      'type' => array('string', 'in'=>array('blogpost')),
      'dt_publish' => array('datetime'),
      'author_id' => array('number'=>'int', 'gt'=>0),
    );
    
  public function get_info()
  {
    
    $ret = Data();
    
    tx('Sql')
      ->table('timeline', 'EntryInfo')
      ->where('entry_id', $this->id)
      ->execute()
      ->each(function($info)use($ret){
        $ret[$info->language_id] = $info;
      });
    
    return $ret;
    
  }
  
  public function get_author()
  {
    
    //If it's not set, take the short route.
    if(!$this->author_id->is_set())
      return null;
    
    return tx('Sql')
      ->table('account', 'Accounts')
      ->pk($this->author_id)
      ->execute_single()
      ->user_info
      ->is('set', function($info){
        $info->full_name;
        $info->status->un_set();
        $info->claim_key->un_set();
        $info->comments->un_set();
      });
    
  }
    
}
