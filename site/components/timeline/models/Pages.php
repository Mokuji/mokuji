<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class Pages extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_pages',
    
    $validate = array(
      'page_id' => array('required', 'number'=>'int', 'gt'=>0),
      'timeline_id' => array('required', 'number'=>'int', 'gt'=>0),
      'display_type_id' => array('required', 'number'=>'int', 'gt'=>0),
      'force_language' => array('number'=>'int', 'gt'=>0),
      'is_chronologic' => array('required', 'boolean'),
      'is_future_hidden' => array('required', 'boolean'),
      'items_per_page' => array('number'=>'int', 'in'=>array(5, 10, 20, 30, 40, 50))
    );
  
  public function get_info()
  {
    
    $ret = Data();
    
    tx('Sql')
      ->table('timeline', 'PageInfo')
      ->where('page_id', $this->page_id)
      ->execute()
      ->each(function($info)use($ret){
        $ret[$info->language_id] = $info;
      });
    
    return $ret;
    
  }
  
}
