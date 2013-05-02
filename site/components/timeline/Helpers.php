<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'get_entries' => 0
    );
  
  public function get_entries($filters, $page = 0)
  {
    
    raw($page);
    
    if($page < 1)
      $page = 1;
    
    $items_per_page = $filters->items_per_page->otherwise(10)->get('int');
    
    //Make a timeframe.
    $dt_start = Data(array(
      'month' => 1,
      'day' => 1
    ));
    $dt_end = Data(array(
      'month' => 1,
      'day' => 1
    ));
    
    //Only if the year is set.
    if($filters->year->is_set()){
      
      $dt_start->year->set($filters->year->get('int'));
      $dt_end->year->set($filters->year->get('int') + 1);
      
      //Further filtering.
      if($filters->month->is_set()){
        
        $dt_start->month->set($filters->month->get('int'));
        $dt_end->year->set($filters->year->get('int'));
        $dt_end->month->set($filters->month->get('int') + 1);
        
        //Further filtering.
        if($filters->day->is_set()){
          
          $dt_start->day->set($filters->day->get('int'));
          $dt_end->month->set($filters->month->get('int'));
          $dt_end->day->set($filters->day->get('int') + 1);
          
        }
        
      }
      
      $dt_start->set(mktime(0,0,0, $dt_start->month->get(), $dt_start->day->get(), $dt_start->year->get()));
      $dt_end->set(mktime(0,0,0, $dt_end->month->get(), $dt_end->day->get(), $dt_end->year->get()));
      
    } else {
      $dt_start->un_set();
      $dt_end->un_set();
    }
    
    //Check if we are trying to search the future, while the future must be hidden.
    if($filters->is_future_hidden->get('boolean') && $dt_start->is_set() && $dt_start->get() > time()){
      return Data(array(
        'pages' => 0,
        'page' => $page,
        'entries' => array(),
        'funny_man' => 'FUTURE_SEARCH'
      ));
    }
    
    $baseTable = tx('Sql')
      ->table('timeline', 'Entries')
      
      //When getting from a timeline_id.
      ->is($filters->timeline_id->get('int') > 0, function($t)use($filters){
        $t->join('EntriesToTimelines', $ET)
          ->where("$ET.timeline_id", $filters->timeline_id);
      })
      
      //When getting from timeline 'NEW'.
      ->is($filters->timeline_id->get('string') == 'NEW', function($t)use($filters){
        #TODO: Validate page ID and permissions.
        $t->pk(tx('Data')->session->timeline->new_page_items->{$filters->page_id});
      })
      
      //Filter the future.
      ->is($filters->is_future_hidden->get('boolean'), function($t)use($dt_start){
        $t->where('dt_publish', '<=', date('Y-m-d H:i:s'));
      })
      
      //Create a time-bracket.
      ->is($dt_start->is_set() && $dt_end->is_set(), function($t)use($dt_start, $dt_end){
        $t->where('dt_publish', '<=', date('Y-m-d H:i:s', $dt_end->get('int')));
        $t->where('dt_publish', '>=', date('Y-m-d H:i:s', $dt_start->get('int')));
      })
      
      //Chronologically?
      ->order('dt_publish', $filters->is_chronologic->get('int') > 0 ? 'ASC' : 'DESC');
      
    $total = $baseTable->count()->get('int');
    
    //Continue filtering.  
    return Data(array(
      'pages' => ceil($total / $items_per_page),
      'page' => $page,
      'entries' => $baseTable
        
        //How many and offset?
        ->limit(
          $items_per_page,
          ($page-1) * $items_per_page
        )
        
        //Go fetch them boy!
        ->execute()
        
        //Call additional getters.
        ->each(function($entry){
          $entry->info;
          $entry->author;
          $entry->is_future;
        })
    ));
    
  }
  
  public function update_entry_info($entry, $infos)
  {
    
    Data($infos)->each(function($info, $lid)use($entry){
      
      try{
      
      //Get existing info (if any).
      tx('Sql')
        ->table('timeline', 'EntryInfo')
        ->pk($entry->id, $lid)
        ->execute_single()
        
        //If none, make an empty one.
        ->is('empty', function()use($entry, $lid){
          return tx('Sql')
            ->model('timeline', 'EntryInfo')
            ->set(array(
              'entry_id' => $entry->id,
              'language_id' => $lid
            ));
        })
        
        //Then set the input.
        ->merge($info)
        
        //Validate.
        ->validate_model(array(
          'nullify' => true
        ))
        
        //Saves :D
        ->save();
      
      }
      
      //We want to wrap these so the keys are properly formatted to the context.
      catch(\exception\ModelValidation $mex){
        format_error_keys($mex, "info[$lid][%s]");
      }
      
    });
    
  }
  
  public function update_entry_timelines($entry, $timelines)
  {
    
    $timelines = Data($timelines);
    
    tx('Sql')
      ->table('timeline', 'Timelines')
      ->execute()
      ->each(function($timeline)use($entry, $timelines){
        
        //Get existing info (if any).
        tx('Sql')
          ->table('timeline', 'EntriesToTimelines')
          ->where('entry_id', $entry->id)
          ->where('timeline_id', $timeline->id)
          ->execute_single()
          
          //If none, make an empty one.
          ->is('empty', function()use($entry, $timeline){
            return tx('Sql')
              ->model('timeline', 'EntriesToTimelines')
              ->set(array(
                'entry_id' => $entry->id,
                'timeline_id' => $timeline->id
              ));
          })
          
          // //Validate.
          // ->validate_model(array(
          //   'force_create' => $info->
          // ))
          
          ->is($timelines->{$timeline->id}->validate('Timeline checkbox', array('boolean'))->is_true())
            
            ->success(function($ET){
              $ET->save();
            })
            
            ->failure(function($ET){
              $ET->delete();
            });
        
      }); //End - each timeline
    
  }
  
}
