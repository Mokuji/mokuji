<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
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
