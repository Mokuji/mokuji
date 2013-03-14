<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class EntryInfo extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_entry_info',
    
    $validate = array(
      'entry_id' => array('required', 'number'=>'int', 'gt'=>0),
      'language_id' => array('required', 'number'=>'int', 'gt'=>0),
      'title' => array('required', 'string', 'not_empty', 'no_html'),
      'summary' => array('string'),
      'content' => array('string')
    );
  
}
