<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  /**
   * Get the entries for a specified timeline.
   */
  protected function get_entries($data, $params)
  {
    
    $page = $params->{0};
    
    return tx('Sql')
      ->table('timeline', 'Entries')
      
      //When getting from a timeline_id.
      ->is($data->timeline_id->get('int') > 0, function($t)use($data){
        $t->join('EntriesToTimelines', $ET)
          ->where("$ET.timeline_id", $data->timeline_id);
      })
      
      //When getting from timeline 'NEW'.
      ->is($data->timeline_id->get('string') == 'NEW', function($t)use($data){
        #TODO: Validate page ID.
        $t->where('id', tx('Data')->session->timline->new_page_items->{$data->page_id});
      })
      
      //Chronologically?
      ->order('dt_publish', $data->is_chronological->get('int') > 0 ? 'ASC' : 'DESC')
      
      //How many and offset?
      ->limit(
        $data->items_per_page->otherwise(10),
        ($page->get('int')-1) * $data->items_per_page->otherwise(10)->get('int')
      )
      
      //Go fetch them boy!
      ->execute()
      
      //Call additional getters.
      ->each(function($entry){
        $entry->info;
        $entry->author;
      });
    
  }
  
  /**
   * Get a page's timeline filters, or resort to the defaults.
   */
  protected function get_page($data, $params)
  {
    
    $display_types = tx('Sql')
      ->table('timeline', 'DisplayTypes')
      ->execute();
    
    $timelines = tx('Sql')
      ->table('timeline', 'Timelines')
      ->where('is_public', true)
      ->execute();
    
    $page = tx('Sql')
      ->table('timeline', 'Pages')
      ->pk($params->{0})
      ->execute_single()
      ->otherwise(array(
        'page_id' => $params->{0}->get('int'),
        'timeline_id'=>'NEW',
        'display_type_id' => $display_types->{0}->id->otherwise(0),
        'is_chronological' => false,
        'is_future_hidden' => true,
        'items_per_page' => 10
      ));
    
    return array(
      'display_types' => $display_types,
      'timelines' => $timelines,
      'page' => $page
    );
    
  }
  
  protected function update_page($data, $params)
  {
    
    //Store multilingual info, validate_model would filter it.
    $info = $data->info;
    
    //See if we need to make a new timeline.
    #TODO
    
    return tx('Sql')
      ->model('timeline', 'Pages')
      ->set($data)
      ->validate_model(array(
      ))
      ->save();
    
  }
  
}
