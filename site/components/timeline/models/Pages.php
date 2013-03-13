<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class Pages extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_pages',
    
    $validate = array(
      'page_id' => array('required', 'number'=>'int', 'gt'=>0),
      'timeline_id' => array('required', 'number'=>'int', 'gt'=>0),
      'display_type_id' => array('required', 'number'=>'int', 'gt'=>0),
      'is_chronologic' => array('required', 'boolean'),
      'is_future_hidden' => array('required', 'boolean')
    );
    
}
