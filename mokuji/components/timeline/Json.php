<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'get_entry' => 0,
      'get_entries' => 0
    );
  
  /**
   * Get one entry.
   */
  protected function get_entry($data, $params)
  {
    
    //Has no permission checks so access level 2.
    
    //Get entry.
    return tx('Sql')
      ->table('timeline', 'Entries')
      ->pk($params->{0})
      ->execute_single()
      
      //Call additional getters.
      ->is('set', function($entry){
        $entry->info;
        $entry->author;
        $entry->is_future;
        $entry->timeline_ids;
        $entry->thumbnail_image;
      })
      
      //Cludge the authors in here.
      ->authors->set(
        tx('Sql')
          ->table('account', 'UserInfo', $UI)
          ->where("(`$UI.status` & (1|4))", '>', 0)
          ->execute()
          ->each(function($info){
            return $info->having('user_id', 'full_name');
          })
      )->back();
    
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
      tx('Data')->session->timeline->new_page_items->{$data->page_id}->push($entry->id);
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
    
    //Create the entry model.
    $data->id = $params->{0}->otherwise($data->id)->get('int');
    $entry = tx('Sql')->table('timeline', 'Entries')->pk($data->id)->execute_model()
    ->merge($data)
    ->validate_model(array(
      'nullify' => true
    ))
    ->save();
    
    // Store if something is stored in the 'NEW' meta-timeline.
    if($timelines->NEW->validate('Timeline checkbox', array('boolean'))->is_true()){
      tx('Data')->session->timeline->new_page_items->{$data->page_id}->push($entry->id);
      $timelines->NEW->un_set();
    }
    
    //Update language specific entry info.
    tx('Component')->helpers('timeline')->_call('update_entry_info', array($entry, $infos));
    
    //Update which time-lines this entry will be attached to, only if info is given.
    if($timelines->is_leafnode()){
      tx('Component')->helpers('timeline')->_call('update_entry_timelines', array($entry, $timelines));
    }
    
    //Return the entry.
    return $entry;
    
  }
  
  /**
   * Moves an entry to 'the trash'. By removing it from all timelines.
   * This makes sure the entry is still preserved and collected in the unlinked items.
   */
  public function delete_entry($data, $params)
  {
    
    //Get the entry.
    $entry = tx('Sql')
      ->table('timeline', 'Entries')
      ->pk($params->{0})
      ->execute_single()
      
      //Check it's there.
      ->is('empty', function($entry){
        throw new \exception\NotFound('The entry with ID "%s" was not found.', $params->{0});
      });
    
    //Do the removing.
    $removed = array();
    
    tx('Sql')
      ->table('timeline', 'EntriesToTimelines')
      ->where('entry_id', $entry->id)
      ->execute()
      ->each(function($link)use(&$removed){
        $link->delete();
        $removed[] = $link->timeline_id->get();
      });
    
    return array(
      'success' => true,
      'removed_from' => $removed
    );
    
  }
  
  /**
   * Get the entries for a specified timeline.
   */
  protected function get_entries($data, $params)
  {
    
    //Helpers::get_entries($filters, $page);
    return tx('Component')->helpers('timeline')->_call('get_entries', array($data, $params->{0}));
    
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
    if($data->timeline_id->get() === 'NEW'){
      
      //Find the language from which to take the title.
      $title_lang = (string)(!$data->force_language->is_empty() ? $data->force_language->get() : tx('Language')->id);
      
      //Create timeline.
      $timeline = tx('Sql')
        ->model('timeline', 'Timelines')
        ->set(array(
          'title' => $data->info->{$title_lang}->title,
          'is_public' => true
        ))
        ->validate_model(array(
          'force_create' => true
        ))
        ->save();
      
      //Store timeline ID in submit data.
      $data->timeline_id->set($timeline->id->get());
      
      //Link items created for this timeline from the session to the DB.
      tx('Data')->session->timeline->new_page_items->{$data->page_id}->each(function($entry)use($timeline){
        
        //Get existing info (if any).
        tx('Sql')
          ->table('timeline', 'EntriesToTimelines')
          ->where('entry_id', $entry)
          ->where('timeline_id', $timeline->id)
          ->execute_single()
          
          //If none, make an empty one.
          ->is('empty', function()use($entry, $timeline){
            return tx('Sql')
              ->model('timeline', 'EntriesToTimelines')
              ->set(array(
                'entry_id' => $entry,
                'timeline_id' => $timeline->id
              ));
          })
          
          //Always save :D
          ->save();
        
      }) //End - each session entry
      
      ->un_set();
      
    }
    
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
    
    $display_types = tx('Sql')
      ->table('timeline', 'DisplayTypes')
      ->execute();
    
    $timelines = tx('Sql')
      ->table('timeline', 'Timelines')
      ->where('is_public', true)
      ->execute();
    
    return array(
      'display_types' => $display_types,
      'timelines' => $timelines,
      'page' => $page
    );
    
  }
  
}
