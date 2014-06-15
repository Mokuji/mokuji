<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class EntriesToTimelines extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_entries_to_timelines',
    
    $relations = array(
      'Entries' => array('entry_id' => 'Entries.id'),
      'Timelines' => array('timeline_id' => 'Timelines.id'),
      'Pages' => array('timeline_id' => 'Pages.timeline_id')
    );
  
}
