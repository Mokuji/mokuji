<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class Timelines extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_timelines',
    
    $relations = array(
      'EntriesToTimelines' => array('id' => 'EntriesToTimelines.timeline_id')
    );
    
}
