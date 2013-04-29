<?php namespace components\timeline\models; if(!defined('TX')) die('No direct access.');

class Entries extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'timeline_entries',
    
    $relations = array(
      'EntriesToTimelines' => array('id' => 'EntriesToTimelines.entry_id'),
      'EntryInfo' => array('id' => 'EntryInfo.entry_id')
    ),
    
    $validate = array(
      'id' => array('required', 'number'=>'int', 'gt'=>0),
      'type' => array('string', 'in'=>array('blogpost')),
      'dt_publish' => array('datetime'),
      'author_id' => array('number'=>'int', 'gt'=>0),
      'thumbnail_image_id' => array('number'=>'int', 'gt'=>0)
    );
  
  public function get_is_future()
  {
    
    return strtotime($this->dt_publish->get('string')) > time();
    
  }
  
  public function get_timelines()
  {
    
    $that = $this;
    $ret = Data();
    
    tx('Sql')
      ->table('timeline', 'Timelines')
      ->execute()
      ->each(function($timeline)use($ret, $that){
        
        if($that->id->is_set()){
          $matched = tx('Sql')
            ->table('timeline', 'EntriesToTimelines')
            ->where('entry_id', $that->id)
            ->where('timeline_id', $timeline->id)
            ->count()->get('int');
        }
        
        else{
          $matched = 0;
        }
        
        $ret[$timeline->id] = $matched > 0;
        
      });
    
    return $ret;
    
  }
  
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
  
  public function get_thumbnail_image()
  {
    
    if(!tx('Component')->available('media'))
      return false;
    
    $image = tx('Sql')
      ->table('media', 'Images')
      ->pk($this->thumbnail_image_id)
      ->execute_single();
    
    $resizeType = tx('Config')->user('timeline.resize-type')->get() == 'fit' ? 'fit' : 'fill';
    $resizeWidth = tx('Config')->user('timeline.resize-width')->otherwise(300)->get('int');
    $resizeHeight = tx('Config')->user('timeline.resize-height')->otherwise(200)->get('int');
    
    return array(
      'id' => $image->id,
      'url' => (string)$image->generate_url(array(
          $resizeType.'_width' => $resizeWidth,
          $resizeType.'_height' => $resizeHeight
        ), array('allow_growth'))
    );
    
  }
    
}
