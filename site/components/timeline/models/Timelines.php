<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class Timelines extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_timelines',
    
    $relations = array(
      'EntriesToTimelines' => array('id' => 'EntriesToTimelines.timeline_id')
    ),
    
    $validate = array(
      'id' => array('required', 'number'=>'int', 'gt'=>0),
      'title' => array('required', 'string', 'not_empty', 'no_html'),
      'is_public' => array('boolean')
    );
    
}
