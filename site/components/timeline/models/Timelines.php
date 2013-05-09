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
 
  public function get_name()
  {

    //Covert title: make it lowercase, remove punctuation, remove multiple/leading/ending spaces.
    $return = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($this->title))));

    //Convert spaces to dashes.
    return str_replace(' ', '-', $return);
    
  }
    
}
