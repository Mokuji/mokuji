<?php namespace components\timeline; if(!defined('TX')) die('No direct access.');


class Modules extends \dependencies\BaseViews
{
  
  protected
    $permissions = array(
      'blog' => 0
    );
  
  protected function blog($options)
  {
    
    //Check for the page ID.
    $options
      ->pid->validate('Page ID', array('required', 'number'=>'integer', 'gt'=>0));
    
    #TODO: check page permissions
    
    //Get the page to base the entries on.
    $page = tx('Sql')
      ->table('timeline', 'Pages')
      ->pk($options->pid->get('int'))
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
    
    //Return the entries.
    return tx('Component')
      ->helpers('timeline')
      ->_call('get_entries', array($page->merge($options->overrides->otherwise(array())->as_array())))
      
      //Template each entry.
      ->entries
        ->each(function($entry)use($page, $options){
          $entry->html->set(tx('Component')
            ->sections($page->display_type->component_name)
            ->get_html($page->display_type->section_name, $entry->merge(array(
              'pid' => $page->page_id,
              'menu' => $options->menu->otherwise('NULL'),
              'language' => $page->language,
              'is_summary' => true
            )))
          );
        })
      ->back();
    
  }
  
}
