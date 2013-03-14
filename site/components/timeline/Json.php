<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  /**
   * Get one entry.
   */
  protected function get_entry($data, $params)
  {
    
    //Get entry.
    return tx('Sql')
      ->table('timeline', 'Entries')
      ->pk($params->{0})
      ->execute_single()
      
      //Call additional getters.
      ->is('set', function($entry){
        $entry->info;
        $entry->author;
        $entry->timelines;
        $entry->authors->set(
          tx('Sql')
            ->table('account', 'UserInfo', $UI)
            ->where("(`$UI.status` & (1|4))", '>', 0)
            ->execute()
            ->each(function($info){
              return $info->having('user_id', 'full_name');
            })
        );
      });
    
  }
  
  protected function create_entry($data, $params)
  {
    
    //Store info, validate_model would filter it.
    $infos = $data->info;
    $timelines = $data->timelines;
    
    //Filter info based on force_language.
    if(!$data->force_language->is_empty()){
      $infos = $infos->having($data->force_language->get('string'));
    }
    
    $entry = tx('Sql')
      ->model('timeline', 'Entries')
      ->set(array('id' => $params->{0}))
      ->merge($data)
      ->validate_model(array(
        'force_create' => true,
        'nullify' => true
      ))
      ->save();
    
    //Store if something is stored in the 'NEW' meta-timeline.
    if($timelines->NEW->validate('Timeline checkbox', array('boolean'))->is_true()){
      tx('Data')->session->timline->new_page_items->{$data->page_id}->push($entry->id);
      $timelines->NEW->un_set();
    }
    
    tx('Component')->helpers('timeline')->_call('update_entry_info', array($entry, $infos));
    tx('Component')->helpers('timeline')->_call('update_entry_timelines', array($entry, $timelines));
    
    return $entry;
    
  }
  
  protected function update_entry($data, $params)
  {
    
    //Store info, validate_model would filter it.
    $infos = $data->info;
    $timelines = $data->timelines;
    
    //Filter info based on force_language.
    if(!$data->force_language->is_empty()){
      $infos = $infos->having($data->force_language->get('string'));
    }
    
    $entry = tx('Sql')
      ->model('timeline', 'Entries')
      ->set(array('id' => $params->{0}))
      ->merge($data)
      ->validate_model(array(
        'nullify' => true
      ))
      ->save();
    
    //Store if something is stored in the 'NEW' meta-timeline.
    if($timelines->NEW->validate('Timeline checkbox', array('boolean'))->is_true()){
      tx('Data')->session->timline->new_page_items->{$data->page_id}->push($entry->id);
      $timelines->NEW->un_set();
    }
    
    tx('Component')->helpers('timeline')->_call('update_entry_info', array($entry, $infos));
    tx('Component')->helpers('timeline')->_call('update_entry_timelines', array($entry, $timelines));
    
    return $entry;
    
  }
  
  /**
   * Get the entries for a specified timeline.
   */
  protected function get_entries($data, $params)
  {
    
    #TODO: hide future items?
    
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
        $t->pk(tx('Data')->session->timline->new_page_items->{$data->page_id});
      })
      
      //Chronologically?
      ->order('dt_publish', $data->is_chronologic->get('int') > 0 ? 'ASC' : 'DESC')
      
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
      ))
      ->info->back();
    
    return array(
      'display_types' => $display_types,
      'timelines' => $timelines,
      'page' => $page
    );
    
  }
  
  protected function update_page($data, $params)
  {
    
    //Store multilingual info, validate_model would filter it.
    $infos = $data->info;
    
    //See if we need to make a new timeline.
    #TODO
    
    $page = tx('Sql')
      ->model('timeline', 'Pages')
      ->set($data)
      ->validate_model(array(
        'nullify' => true
      ))
      ->save();
    
    $infos->each(function($info, $lid)use($page){
      
      //Get existing info (if any).
      tx('Sql')
        ->table('timeline', 'PageInfo')
        ->pk($page->page_id, $lid)
        ->execute_single()
        
        //If none, make an empty one.
        ->is('empty', function()use($page, $lid){
          return tx('Sql')
            ->model('timeline', 'pageInfo')
            ->set(array(
              'page_id' => $page->page_id,
              'language_id' => $lid
            ));
        })
        
        //Then set the input.
        ->merge($info)
        
        // //Validate.
        // ->validate_model(array(
        //   'force_create' => $info->
        // ))
        
        //Saves :D
        ->save();
      
    });
    
    return $page;
    
  }
  
  protected function update_page_title($data, $params)
  {
    
    $page = tx('Sql')
      ->table('timeline', 'Pages')
      ->pk($data->page_id)
      ->execute_single()
      
      ->is('empty', function()use($data){
        throw new \exception\NotFound('No page with page ID "%s".', $data->page_id);
      });
    
    $data->info->each(function($info, $lid)use($page){
      
      //Get existing info (if any).
      tx('Sql')
        ->table('timeline', 'PageInfo')
        ->pk($page->page_id, $lid)
        ->execute_single()
        
        //If none, make an empty one.
        ->is('empty', function()use($page, $lid){
          return tx('Sql')
            ->model('timeline', 'pageInfo')
            ->set(array(
              'page_id' => $page->page_id,
              'language_id' => $lid
            ));
        })
        
        //Then set the input.
        ->merge($info)
        
        // //Validate.
        // ->validate_model(array(
        //   'force_create' => $info->
        // ))
        
        //Saves :D
        ->save();
      
    });
    
    return $page->info->back();
    
  }
  
}
