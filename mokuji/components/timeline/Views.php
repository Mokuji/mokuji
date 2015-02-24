<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');

use \components\timeline\models\Entries;

class Views extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
      'blog' => 0
    );
  
  protected function blog($options)
  {
    
    $pid = $options->pid->value->otherwise(tx('Data')->get->pid);
    $menu = $options->menu->value->otherwise(tx('Data')->get->menu);
    $page_nr = $options->page->value->otherwise(tx('Data')->get->page);
    $post = $options->post->value->otherwise(tx('Data')->get->post);
    $year = $options->year->value->otherwise(tx('Data')->get->year);
    $month = $options->month->value->otherwise(tx('Data')->get->month);
    $day = $options->day->value->otherwise(tx('Data')->get->day);
    
    #TODO: check page permissions
    
    $page = tx('Sql')
      ->table('timeline', 'Pages')
      ->pk($pid->get('int'))
      ->execute_single()
      ->is('empty', function(){
        throw new \exception\NotFound('No configuration found for this blog page.');
      })
      
      //Store the requested language.
      ->is('set', function($page){
        $page->merge(array(
          'language' => $page->force_language->otherwise(tx('language')->id)
        ));
      });
    
    //If a specific item is requested.
    if(false && $post->is_set()){
      
      //Verify it's in the timeline.
      tx('Sql')
        ->table('timeline', 'EntriesToTimelines')
        ->where('entry_id', $post)
        ->where('timeline_id', $page->timeline_id)
        ->count()->eq(1)
        ->failure(function()use($post){
          throw new \exception\NotFound('The post with ID "%s" was not found in this timeline.', $post);
        });
      
      //Get the entry.
      $entry = tx('Sql')
        ->table('timeline', 'Entries')
        ->pk($post)
        ->execute_single()
        ->is('empty', function()use($post){
          throw new \exception\NotFound('The post with ID "%s" is missing.', $post);
        });
      
      //Template it.
      $entry->html->set(
        tx('Component')
          ->sections($page->display_type->component_name)
          ->get_html($page->display_type->section_name, $entry->merge(array(
            'pid' => $page->page_id,
            'menu' => $menu->otherwise('NULL'),
            'language' => $page->language,
            'is_summary' => false
          )))
      );
      
      //Give 'em the entry in a wrapper.
      return array('entries'=>array($entry));
      
    }
    
    //If we're not getting just one post.
    else{
      
      //Use the helper to get the matching entries.
      return tx('Component')
        ->helpers('timeline')
        ->_call('get_entries', array($page->merge(array(
          'year' => $year,
          'month' => $month,
          'day' => $day
        )), $page_nr))
        
        //Template each entry.
        ->entries
          ->each(function($entry)use($page, $menu){
            $entry->html->set(tx('Component')
              ->sections($page->display_type->component_name)
              ->get_html($page->display_type->section_name, $entry->merge(array(
                'pid' => $page->page_id,
                'menu' => $menu->otherwise('NULL'),
                'language' => $page->language,
                'is_summary' => true
              )))
            );
          })
        ->back();
      
    }
    
  }
  
}
